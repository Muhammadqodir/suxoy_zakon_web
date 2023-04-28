<?php

class DBHelper
{


  public $mysqli;

  function __construct()
  {
    require "config.php";

    $this->mysqli = new mysqli($host, $user, $password, $db);

    $this->mysqli->set_charset("utf8");

    // Check connection
    if ($this->mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
      exit();
    }
  }

  function getField($field)
  {
    $sql = "SELECT * FROM fields WHERE field='$field'";
    if ($result = $this->mysqli->query($sql)) {
      return $result->fetch_assoc()["value"];
    } else {
      return "undefined";
    }
  }

  function getUser($token)
  {
    $sql = "SELECT * FROM users WHERE token='$token'";
    if ($result = $this->mysqli->query($sql)) {
      return $result->fetch_assoc();
    } else {
      return "undefined";
    }
  }

  function register($phone)
  {
    $sql = "SELECT * FROM users WHERE phone = '$phone'";
    if ($result = $this->mysqli->query($sql)) {
      $row = $result->fetch_assoc();
      if ($row != null && $row != false) {
        return $row;
      } else {
        if ($this->newUser($phone)) {
          return $this->register($phone);
        } else {
          return "undefined";
        }
      }
    } else {
      return "undefined";
    }
  }

  function generateToken($length)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  function newOrder($userId, $items, $payment, $destination, $price, $note)
  {
    $date = date("d.m.Y H:i:s");
    $sql = "INSERT INTO `orders` (`id`, `user_id`, `positions`, `date`, `status`, `payment_type`, `delivery`, `totalPrice`, `note`) 
    VALUES (NULL, $userId, '$items', '$date', 'Отправлено', '$payment', '$destination', '$price', '$note');";
    
    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function newUser($phone)
  {
    $token = $this->generateToken(16);
    $sql = "INSERT INTO users (phone, fullName, gender, birth_day, token) VALUES ('$phone', 'undefined', 'undefined', 'undefined', '$token')";

    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function newMenuPosition($title, $description, $price, $category, $pic)
  {
    $sql = "INSERT INTO `menu` (`title`, `description`, `available`, `pic`, `price`, `category`) 
    VALUES ('$title', '$description', 1, '$pic', $price, '$category')";

    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function removeMenuPosition($id)
  {

    $sql = "DELETE FROM menu WHERE id = $id";

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

  function getAllMenu()
  {
    $res = [];
    $sql = "SELECT * FROM menu";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }
  function getDestinations()
  {
    $res = [];
    $sql = "SELECT * FROM destinations";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }

  function getMenuByCat($cat)
  {
    $res = [];
    $sql = "SELECT * FROM menu WHERE category='$cat'";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }
  function search($q)
  {
    $res = [];
    $sql = "SELECT * FROM menu WHERE title LIKE '%$q%'";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }

  function getCategories()
  {
    $res = [];
    $sql = "SELECT DISTINCT(category) FROM menu;";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $res[] = $row["category"];
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
