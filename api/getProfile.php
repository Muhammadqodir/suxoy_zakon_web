<?php
require "db_helper.php";

$res = [];

$res["isSuccess"] = false;
$res["message"] = "Invalid request";
$res["data"] = null;
if (
  isset($_GET["token"])
) {

  $db = new DBHelper();

  $user = $db->getUser($_GET["token"]);
  if($user != null){
    $res["isSuccess"] = true;
    $res["message"] = "ok";
    $res["data"] = $user;
  }

}


header('Content-Type: application/json; charset=utf-8');
echo json_encode($res);
