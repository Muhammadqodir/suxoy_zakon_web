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

  function deleteUser($token)
  {
    $sql = "DELETE FROM users WHERE token='$token'";
    if ($result = $this->mysqli->query($sql)) {
      return true;
    } else {
      return "undefined";
    }
  }

  function getUserById($id)
  {
    $sql = "SELECT * FROM users WHERE id=$id";
    if ($result = $this->mysqli->query($sql)) {
      return $result->fetch_assoc();
    } else {
      return array("id"=>-1, "fullName"=>"Удаленный пользователь", "phone"=> "Удаленный пользователь");
    }
  }
  function getDestinationById($id)
  {
    $sql = "SELECT * FROM destinations WHERE id=$id";
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

  function newOrder($userId, $items, $payment, $destination, $price, $note, $sdacha, $address)
  {
    $date = date("d.m.Y H:i:s");
    $sql = "INSERT INTO `orders` (`id`, `user_id`, `positions`, `date`, `status`, `payment_type`, `delivery`, `totalPrice`, `note`, `stacha`, `address`) 
    VALUES (NULL, $userId, '$items', '$date', 'Отправлено', '$payment', '$destination', '$price', '$note', '$sdacha', '$address');";
    
    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function newDestination($name, $price)
  {
    $sql = "INSERT INTO `destinations` (`id`, `destination`, `price`) 
    VALUES (NULL, '$name', '$price');";
    
    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }
  function editDestination($id, $name, $price)
  {
    $sql = "UPDATE `destinations` SET `destination` = '$name', `price` = '$price' WHERE id = $id;";
    
    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function setField($key, $value)
  {
    $sql = "UPDATE `fields` SET `value` = '$value' WHERE field = '$key';";
    
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

  function saveUser($id, $userName, $birthDay, $sex)
  {
    $sql = "UPDATE users SET fullName = '$userName', gender = '$sex', birth_day = '$birthDay' WHERE id = $id";

    if ($this->mysqli->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  function updateOrderStatus($id, $status)
  {
    $sql = "UPDATE orders SET status = '$status' WHERE id = $id";

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

  function editMenuPosition($id, $title, $description, $price, $category, $pic)
  {
    $sql = "UPDATE `menu` SET `title`='$title', `description`='$description', `pic`='$pic', `price`=$price, `category`='$category'
    WHERE id = $id";
    if($pic == ""){
      $sql = "UPDATE `menu` SET `title`='$title', `description`='$description', `price`=$price, `category`='$category'
      WHERE id = $id";
    }

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

  function removeDestination($id)
  {

    $sql = "DELETE FROM destinations WHERE id = $id";

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
      while ($row = $result->fetch_assoc()) {
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

  function getAllOrders($page, $limit)
  {
    $res = [];
    $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT $page, $limit";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $row["user"] = $this->getUserById($row["user_id"]);
        $row["destination"] = $this->getDestinationById($row["delivery"]);
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }

  function getOrdersCount()
  {
    $res = [];
    $sql = "SELECT COUNT(*) FROM orders";

    if ($result = $this->mysqli->query($sql)) {
      return $result->fetch_row();
    }

    return 0;
  }

  function getAllActiveOrders()
  {
    $res = [];
    $sql = "SELECT * FROM orders WHERE status != 'Готово' AND status != 'Отменено' ORDER BY id DESC";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $row["user"] = $this->getUserById($row["user_id"]);
        $row["destination"] = $this->getDestinationById($row["delivery"]);
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }

  function getAllUsers()
  {
    $res = [];
    $sql = "SELECT * FROM users";

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

  function getOrders($id)
  {
    $res = [];
    $sql = "SELECT * FROM orders WHERE user_id=$id ORDER BY id DESC";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $row["destination"] = $this->getDelivery($row["delivery"]);
        $res[] = $row;
      }
      $result->free_result();
    }

    return $res;
  }

  function getDelivery($id){
    $sql = "SELECT * FROM destinations WHERE id=$id";

    if ($result = $this->mysqli->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        return $row;
      }
      $result->free_result();
    }

    return ["id"=>"-1", "destination"=>"undefined", "price"=>"0"];
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

  function getPositionById($id)
  {
    $sql = "SELECT * FROM menu WHERE id = $id";

    if ($result = $this->mysqli->query($sql)) {
      return $result->fetch_assoc();
    }

    return null;
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
