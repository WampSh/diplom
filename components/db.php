<?php
$dbhost = "localhost";
$dbuser = "wamps_gool";
$dbpass = "3Q3hR%kK";
$dbname = "wamps_gool";
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$mysqli->set_charset("utf-8");

if ($mysqli->connect_error) {
  die("Не удалось подключиться к БД ".$mysqli->connect_error);
}
?>