<?
session_start();
header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="ru">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <meta charset="UTF-8">
  <title>Футбол</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?
  if (!isset($_SESSION['id'])): 
   require_once("components/reg.php"); 
   endif;
  ?>
  <header class="head">
    <nav class="navbar navbar-expand-lx navbar-light bg-success">
      <div class="clock"></div>
      <div class="username"><?=strtoupper($_SESSION['nick'])?></div>
      <div class="schet">
        <img allign="center" src="img/0.png" alt=""><img allign="center" src="img/0.png" alt=""><img allign="center" src="img/points.png" alt=""><img allign="center" src="img/0.png" alt=""><img allign="center" src="img/0.png" alt="">
      </div>
      <div class="compname">КОМПЬЮТЕР</div>
      <div class="btn-group">
        <button type="button" class="navbar-toggler" data-toggle="dropdown" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div class="dropdown-menu dropdown-menu-right">
          <button class="dropdown-item" onclick= "scores()" type="button">Рекорды</button>
          <a href="components/exit.php" class="dropdown-item exit" type="button">Выход</a>
          <button class="dropdown-item" onclick= "about()" type="button">О создателе игры</button>
        </div>
      </div>
    </nav>
  </header>
  <main class="main">
   <div class="flexdiv"></div>
    <div><img class="plate" src="./img/footbolplate.jpeg" width="1260px" height="800px" alt=""></div>
    <div class="vorotal"><img src="./img/vorotal.png" alt=""></div>
    <div class="vorotar"><img src="./img/vorotar.png" alt=""></div>
    <div class="bollone">
      <div class="boll"><img src="./img/ball.svg" width="50px" height="50px" alt=""></div>
    </div>
    <div class="compMan"><img src="./img/CompMan1.png" alt=""></div>
    <div class="startModal start">
      <div class="aboutText">Добро пожаловать в игру Гооол!<br></div>
        <div class="startText">
        Цель игры забить как можно больше голов в ворота противника (слева) и постараться не пропустить голы в свои ворота (справа). Удар по мячу при помощи клика мыши вокруг мяча, чем дальше от мяча клик, тем сильнее удар.<br> Всё очень просто, надо только начать.
        </div>
      <button type="button" class="btn btn-primary" onclick="startGame()">Начать игру</button>
      <a href="components/exit.php" class="btn btn-primary exit" type="button">Выход</a>
    </div>
  </main>
  <script src="script.js"></script>
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>