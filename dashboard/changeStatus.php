<?php
require "../config.php";
require "../db_helper.php";
require "../routing.php";
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

if(
  isset($_GET["id"]) &&
  isset($_GET["status"])
){
  $db = new DBHelper();
  $db->updateOrderStatus($_GET["id"], $_GET["status"]);
}else{
  echo "Bad Reuest!";
}