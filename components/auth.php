<?php
  session_start();
  header('Content-Type: text/html; charset=utf-8');
  
  $nick = htmlspecialchars( trim($_POST["nick"]) );
  $password = htmlspecialchars( trim($_POST["password"]) );
  $secpassword = htmlspecialchars( trim($_POST["secpassword"]) );
  $reg = $_POST["reg"];
  if (empty($nick) || empty($password)) exit("empty");
  if ($reg == "on" && $password != $secpassword) exit("noequil");
  require_once("db.php");
  if ($reg == "off"){
  $result = $mysqli -> query("SELECT * FROM `players` WHERE `nick`= '$nick'") -> fetch_assoc();
    if (isset($result) && password_verify($password, $result["password"])) {
      $_SESSION['id'] = $result['id'];
      $_SESSION['nick'] = $result['nick'];
      $_SESSION['score'] = $result['score'];
      exit("sucsess");
    } else exit("wrong");
  } else {
    if (mb_strlen($password) < 4 ) {
      exit("lessfore");
    } else $password = password_hash($password, PASSWORD_BCRYPT);
    $result = $mysqli -> query("SELECT * FROM `players` WHERE `nick`= '$nick'") -> fetch_assoc();
    if (isset($result)) { exit("allready");}
    $result = $mysqli -> query("INSERT INTO `players`(`nick`,`password`) VALUES('$nick','$password')"); 
    if ($result) {
      $result = $mysqli -> query("SELECT * FROM `players` WHERE `nick`= '$nick'") -> fetch_assoc();
      $_SESSION['id'] = $result['id'];
      $_SESSION['nick'] = $result['nick'];
      $_SESSION['score'] = $result['score'];
      exit ("sucsess");
    } else {
      ("error");
    }
  }
?>    