<?php
require "../config.php";
require "../routing.php";
require "../db_helper.php";
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

$db = new DBHelper();
$data = $db->getUsers();
header('Content-Type: text/json; charset=utf-8');

echo json_encode($data);

// $filename =  time().".xls";
// header("Content-Type: application/vnd.ms-excel");
// header("Content-Disposition: attachment; filename=\"$filename\"");

// ExportFile($data);
// function ExportFile($records) {
//     $heading = false;
//         if(!empty($records))
//           foreach($records as $row) {
//             if(!$heading) {
//               // display field/column names as a first row
//               echo implode("\t", array_keys($row)) . "\n";
//               $heading = true;
//             }
//             echo implode("\t", array_values($row)) . "\n";
//         }
//     exit;
// }
