<?php
require "../db_helper.php";

$res = [];

$res["isSuccess"] = false;
$res["message"] = "Invalid data";
$res["data"] = false;
if (
  isset($_POST["items"]) &&
  isset($_POST["destination"]) &&
  isset($_POST["totalPrice"]) &&
  isset($_POST["paymentMethod"]) &&
  isset($_POST["note"]) &&
  // isset($_POST["address"]) &&
  // isset($_POST["sdacha"]) &&
  isset($_POST["token"])
) {

  $db = new DBHelper();

  $user = $db->getUser($_POST["token"]);
  if($user != null){
    $res["isSuccess"] = true;
    $res["message"] = "ok";
    // $res["data"] = $db->newOrder($user["id"], $_POST["items"], $_POST["paymentMethod"], $_POST["destination"], $_POST["totalPrice"], $_POST["note"], $_POST["sdacha"], $_POST["address"]);
    $res["data"] = $db->newOrder($user["id"], $_POST["items"], $_POST["paymentMethod"], $_POST["destination"], $_POST["totalPrice"], $_POST["note"], "", "");
  }

}


header('Content-Type: application/json; charset=utf-8');
echo json_encode($res);
