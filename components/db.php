<?php
$dbhost = "wamps.beget.tech";
$dbuser = "wamps_gool";
$dbpass = "i6lRSnf5";
$dbname = "wamps_gool";
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$mysqli->set_charset("utf-8");

if ($mysqli->connect_error) {
  die("Не удалось подключиться к БД ".$mysqli->connect_error);
}
?>