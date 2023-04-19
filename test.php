<?php
require("db_helper.php");

$db = new DBHelper();

$users = $db->getUsers();

print_r(count($users));

?>