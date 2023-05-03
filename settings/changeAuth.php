<?php
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

require "../db_helper.php";
require "../routing.php";

if (
  isset($_GET["login"]) &&
  isset($_GET["password"])
) {
  if (
    $_GET["login"] != "" &&
    $_GET["password"] != ""
  ) {
    $db = new DBHelper();
    $db->setField("login", $_GET["login"]);
    $db->setField("password", $_GET["password"]);
    goToRoute("settings");
  } else {
    goBackWithMessage("Введите корректные данные!");
  }
} else {
  goBackWithMessage("Неверный формат запроса!");
}
