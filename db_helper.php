<?php

class DBHelper
{


  public $mysqli;

  function __construct()
  {
    require "config.php";

    $this->mysqli = new mysqli($host, $user, $password, $db);

    // Check connection
    if ($this->mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
      exit();
    }
  }

  function newUser($phone)
  {
    $sql = "INSERT INTO users (phone, fullName, gender, birth_day) VALUES ('$phone', 'undefined', 'undefined', 'undefined')";

    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function getUsers()
  {
    $res = [];
    $sql = "SELECT * FROM users";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_row()) {
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }

  function closeConnection()
  {
    $this->mysqli->close();
  }
}
