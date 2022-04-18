<?php

class SiteController
{

    public function actionIndex()
    {

        if($this->checkAuth()) {
            header('Location: /cabinet');
        }

        require_once(ROOT . '/views/main/index.php');

        return true;
    }

    public function actionAuth() {
        $login = $_POST['login'] ?? false;
        $password = md5($_POST['password']) ?? false;

        $errors = []; // ошибки

        // небольшая валидация на существование post
        if(!$login || !$password) {
            header('Location: /');
            exit('Без post не пускаю');
        }

        // найденный пользователь по логину и паролю, возвращает массив id и login
        $user = Users::getUserByLoginAndPassword($login, $password);

        if($user) {
            // токен для хранения куки в бд, лучше использовать другую хэш функцию, чтобы уменьшить вероятность коллизии
            $token = md5($user['id'].$user['login']);

            // жизнь куки 7 дней
            $expires = time()+3600*24*7;

            if(Users::addToken($user['id'], $token, $expires)) {
                setcookie("user_token", $token, $expires); // устанавливаем время жизни куки 7 дней
                header('Location: /cabinet');
            } else {
                $errors[] = 'Не удалось создать сессию';
            }
        } else {
            $errors[] = 'Неверный логин или пароль';
        }

        require_once(ROOT . '/views/main/index.php');

        return false;
    }

    public function actionCabinet() {
        // Проверка на авторизованность

        if(!$user = $this->checkAuth()) {
            header('Location: /');
            exit;
        }

        $user = Users::getUserById($user['user_id']);

        require_once(ROOT . '/views/main/cabinet.php');

    }

    public function actionCabinetUpdate() {
        // Проверка на авторизованность

        if(!$user = $this->checkAuth()) {
            header('Location: /');
            exit;
        }

        // массив для post данных
        $data = [];

        $data['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : false;
        $data['patronymic'] = isset($_POST['patronymic']) ? htmlspecialchars($_POST['patronymic'], ENT_QUOTES) : false;
        $data['surname'] = isset($_POST['surname']) ? htmlspecialchars($_POST['surname'], ENT_QUOTES) : false;
        $data['password'] = isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : false;
        $data['old_password'] = isset($_POST['old_password']) ? htmlspecialchars($_POST['old_password'], ENT_QUOTES) : false;

        if($data['password'] == '') $data['password'] = $data['old_password'];
        else $data['password'] = md5($data['password']);

        $errors = $this->validateForm($data);

        if(empty($errors) && !empty($user)) {
            if(!Users::updateUser($user['user_id'], $data)) {
                $errors[] = 'Данные в базу данных не добавлены';
            }
        }

        require_once(ROOT . '/views/main/update.php');

    }

    public function actionLogout() {
        if(isset($_COOKIE['user_token']) && !empty($_COOKIE['user_token']) && isset($_POST['button_logout'])) {

            Users::clearTokens($_COOKIE['user_token']);

            unset($_COOKIE['user_token']);
            setcookie('user_token', null, -1, '/'); // удаляем куки

            header('Location: /');
        } else {
            exit;
        }
    }

    public function actionRegister() {

        if(isset($_POST['register-button'])) {
            $data = [];

            $data['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : false;
            $data['patronymic'] = isset($_POST['patronymic']) ? htmlspecialchars($_POST['patronymic'], ENT_QUOTES) : false;
            $data['surname'] = isset($_POST['surname']) ? htmlspecialchars($_POST['surname'], ENT_QUOTES) : false;
            $data['email'] = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : false;
            $data['login'] = isset($_POST['login']) ? htmlspecialchars($_POST['login'], ENT_QUOTES) : false;
            $data['password'] = isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : false;

            $errors = $this->validateForm($data);

            $data['password'] = md5($data['password']);

            if(empty($errors)) {
                // проверку на email не делаю, два юзера могут иметь одинаковый email (это неправильно)
                if(Users::getUserByLogin($data['login']) || Users::getUserByEmail($data['email'])) {
                    $errors[] = 'Такой логин или email уже существует';
                } else {
                    Users::addUser($data);
                    $user= Users::getUserByLogin($data['login']);

                    $expires = time()+3600*24*7;
                    $token = md5($user['id'].$user['login']);

                    setcookie("user_token", $token, $expires); // устанавливаем время жизни куки 7 дней
                    Users::addToken($user['id'], $token, $expires);

                    header('Location: /cabinet');
                }
            }
        }

        require_once ROOT.'/views/main/register.php';

        return true;
    }

    public function checkAuth() {
        if(isset($_COOKIE['user_token']) && !empty($_COOKIE['user_token'])) {
            $token = $_COOKIE['user_token'];
            $user = Users::getUserByToken($token);
            if($user) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function validateForm($data) {
        $errors = [];
        foreach ($data as $key => $item) {
            if(strlen($item) > 30 && $key != 'password' && $key != 'old_password') {
                $errors[] = 'Одно из полей содержит больше 30и символов';
                break;
            } else if(!$item) {
                $errors[] = 'Есть пустое поле';
                break;
            }
        }

        return $errors;
    }
}
