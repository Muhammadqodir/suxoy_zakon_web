<?php
require "db_helper.php";

$res = [];

$res["isSuccess"] = false;
$res["message"] = "Invalid request";
$res["data"] = null;
if (
  isset($_POST["token"]) &&
  isset($_POST["userName"]) &&
  isset($_POST["birthDay"]) &&
  isset($_POST["sex"])
) {

  $db = new DBHelper();

  $user = $db->getUser($_POST["token"]);
  if($user != null){
    $db->saveUser($user["id"], $_POST["userName"], $_POST["birthDay"], $_POST["sex"]);
    $user = $db->getUser($_POST["token"]);
    $res["isSuccess"] = true;
    $res["message"] = "ok";
    $res["data"] = $user;
  }

}


header('Content-Type: application/json; charset=utf-8');
echo json_encode($res);
