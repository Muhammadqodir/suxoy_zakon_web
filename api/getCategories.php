<?php
require "db_helper.php";

$res = [];
$db = new DBHelper();
$res["isSuccess"] = true;
$res["message"] = "ok";
$res["data"] = $db->getCategories();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($res);