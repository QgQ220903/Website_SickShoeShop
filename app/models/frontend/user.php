<?php
class User extends Database
{
  private $error = "";
  function register($POST)
  {

    $username = $POST['username'];
    $email = $POST['email'];
    $phone = $POST['phone'];
    $password = $POST['password'];

    // Kiểm tra email duy nhất
    $query = "SELECT COUNT(*) FROM `user` WHERE `email` = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
      echo "Email đã có tài khoản khác sử dụng";
    } else {
      // nếu không bị lỗi nào thực hiện thêm vào cơ sở dữ liệu
      $date = date("Y-m-d H:i:s");
      $password = hash('sha1', $password);
      $query = "INSERT INTO `user` (`id`, `role_id`, `email`, `username`, `password`, `phone`, `date`, status) 
      VALUES (NULL, 5, ?, ?, ?, ?, ?, 1);";
      $stmt = $this->conn->prepare($query);
      $result = $stmt->execute([$email, $username, $password, $phone, $date]);
      if ($result) {
        echo "Đăng ký thành công";
      }
    }
  }


  function login($POST)
  {
    if (isset($POST['email']) && isset($POST['password'])) {
      $email = $POST['email'];
      $password = $POST['password'];

      $password = hash('sha1', $password);
      $query = "select * from user where email = ? AND password = ? and status = 1";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$email, $password]);
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
      if (is_array($result) && count($result) > 0) {
        $_SESSION['user_id'] = $result[0]->id;
        echo "Đăng nhập thành công";
      } else {
        echo "Tài khoản không tồn tại";
      }
    }
  }

  function check_login()
  {
    if (isset($_SESSION['user_id'])) {
      $query = "select * from user where id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$_SESSION['user_id']]);
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
      if (is_array($result) && count($result) > 0) {
        return $result[0];
      }
    }
    return null;
  }
  function get_user($id)
  {
    if (isset($_SESSION['user_id'])) {
      $query = "select * from user where id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$_SESSION['user_id']]);
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
      if (is_array($result) && count($result) > 0) {
        return $result[0];
      }
    }
    return null;
  }

  function logout()
  {
    if (isset($_SESSION['user_id'])) {
      unset($_SESSION['user_id']);
    }
  }
}