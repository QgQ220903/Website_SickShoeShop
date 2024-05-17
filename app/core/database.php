<?php

class Database
{
  protected $conn;
  protected $dsn = "mysql:host=localhost;dbname=eshopdb";
  protected $username = "root";
  protected $password = "";

  function __construct()
  {
    try {
      $this->conn = new PDO($this->dsn, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}
?>