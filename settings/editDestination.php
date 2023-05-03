<?php
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

require "../db_helper.php";
require "../routing.php";

if (
  isset($_GET["region"]) &&
  isset($_GET["id"]) &&
  isset($_GET["price"])
) {

  $db = new DBHelper();
  $db->editDestination($_GET["id"], $_GET["region"], $_GET["price"]);
  goToRoute("settings");
} else {
  goBackWithMessage("Неверный формат запроса!");
}
