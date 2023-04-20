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

  function getField($field){
    $sql = "SELECT * FROM fields WHERE field='$field'";

    if ($result = $this->mysqli->query($sql)) {
      return $result->fetch_assoc()["value"];
    }else{
      return "undefined";
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

  function removeMenuPosition($id){

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
