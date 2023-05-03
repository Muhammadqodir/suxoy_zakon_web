<?php
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

require "../db_helper.php";
require "../routing.php";

if (isset($_GET["id"])) {
  if($_GET["id"]>=0){
    $db = new DBHelper();
    $db->removeDestination($_GET["id"]);
    goToRoute("settings");
  }else{
    goBackWithMessage("Неверный формат запроса!");
  }
} else {
  goBackWithMessage("Неверный формат запроса!");
}
