<?php
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

require "../db_helper.php";
require "../routing.php";

if (
  isset($_GET["key"]) &&
  isset($_GET["value"])
) {
  if (
    $_GET["key"] != "" &&
    $_GET["value"] != ""
  ) {
    $db = new DBHelper();
    $db->setField($_GET["key"], $_GET["value"]);
    goToRoute("settings");
  } else {
    goBackWithMessage("Введите корректные данные!");
  }
} else {
  goBackWithMessage("Неверный формат запроса!");
}
