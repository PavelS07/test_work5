<?php 

class Users
{

  public static function getUserByLoginAndPassword($login, $password) {
      $db = Db::getConnection();

      $sql = 'SELECT id, login FROM users WHERE login=:login AND password=:password';

      $result = $db->prepare($sql);
      $result->bindParam(':login', $login, PDO::PARAM_STR);
      $result->bindParam(':password', $password, PDO::PARAM_STR);

      $result->execute();

      $user = $result->fetch(PDO::FETCH_ASSOC);

      return $user;
  }

  public static function getUserById($userId) {
      $userId = intval($userId);

      $db = Db::getConnection();

      $sql = 'SELECT * FROM users WHERE id=:id';

      $result = $db->prepare($sql);
      $result->bindParam(':id', $userId, PDO::PARAM_INT);

      $result->execute();

      $user = $result->fetch(PDO::FETCH_ASSOC);

      return $user;
  }

    public static function getUserByLogin($login) {
        $db = Db::getConnection();

        $sql = 'SELECT id FROM users WHERE login=:login';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);

        $result->execute();

        $user = $result->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public static function getUserByToken($token) {
        $db = Db::getConnection();

        $sql = 'SELECT user_id FROM tokens WHERE token=:token';

        $result = $db->prepare($sql);
        $result->bindParam(':token', $token, PDO::PARAM_STR);

        $result->execute();

        $user = $result->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public static function getUserByEmail($email) {
        $db = Db::getConnection();

        $sql = 'SELECT id FROM users WHERE email=:email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);

        $result->execute();

        $user = $result->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public static function addToken($id, $token, $expires) {
      $id = intval($id);

      $db = Db::getConnection();

      $sql = 'INSERT INTO tokens (user_id, token, expires) '
          . 'VALUES (:user_id, :token, :expires)';

      $result = $db->prepare($sql);

      $result->bindParam(':user_id', $id, PDO::PARAM_INT);
      $result->bindParam(':token', $token, PDO::PARAM_STR);
      $result->bindParam(':expires', $expires, PDO::PARAM_INT);

      return $result->execute();
  }

  public static function addUser($data) {
      $db = Db::getConnection();

      $sql = 'INSERT INTO users (name, patronymic, surname, email, login, password) '
          . 'VALUES (:name, :patronymic, :surname, :email, :login, :password)';

      $result = $db->prepare($sql);

      $result->bindParam(':name', $data['name'], PDO::PARAM_STR);
      $result->bindParam(':patronymic', $data['patronymic'], PDO::PARAM_STR);
      $result->bindParam(':surname', $data['surname'], PDO::PARAM_STR);
      $result->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $result->bindParam(':login', $data['login'], PDO::PARAM_STR);
      $result->bindParam(':password', $data['password'], PDO::PARAM_STR);

      return $result->execute();
  }

  public static function updateUser($id, $data) {
      $id = intval($id);

      $db = Db::getConnection();

      $sql = 'UPDATE users SET name=:name, patronymic=:patronymic, surname=:surname, password=:password WHERE id=:id';

      $result = $db->prepare($sql);
      $result->bindParam(':id', $id, PDO::PARAM_INT);
      $result->bindParam(':name', $data['name'], PDO::PARAM_STR);
      $result->bindParam(':patronymic', $data['patronymic'], PDO::PARAM_STR);
      $result->bindParam(':surname', $data['surname'], PDO::PARAM_STR);
      $result->bindParam(':password', $data['password'], PDO::PARAM_STR);

      return $result->execute();

  }

    public static function clearTokens($token) {
        $db = Db::getConnection();

        $sql = 'DELETE FROM tokens WHERE token=:token';

        $result = $db->prepare($sql);
        $result->bindParam(':token', $token, PDO::PARAM_STR);

        return $result->execute();
    }
}

?>