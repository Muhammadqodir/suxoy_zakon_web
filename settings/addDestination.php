<?php
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

require "../db_helper.php";
require "../routing.php";

if (
  isset($_GET["title"]) &&
  isset($_GET["price"])
) {

  $db = new DBHelper();
  $db->newDestination($_GET["title"], $_GET["price"]);
  goToRoute("settings");
} else {
  goBackWithMessage("Неверный формат запроса!");
}
