<?php
  session_start();
  header('Content-Type: text/html; charset=utf-8');
  $id = $_SESSION['id'];
  $score = $_POST['score'];
  require_once("db.php");
  if (($_SESSION['score']) < $score){
    $result = $mysqli -> query("UPDATE `players` SET `score`= '$score' WHERE `id`= '$id'") -> fetch_assoc();
    if ($result) {
      $_SESSION['score'] = $score;
      exit ("OK");
    } else {
      exit("Error");
    }
  }
  ?> 