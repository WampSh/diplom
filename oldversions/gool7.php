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
    <div id="bollone" class="bollaura">
      <div class="boll"><img src="./img/ball.svg" width="50px" height="50px" alt=""></div>
    </div>
    <div id="compMan" class="compMan"><img src="./img/CompMan1.png" alt=""></div>
    <div class="startModal start">
      <div class="aboutText">Добро пожаловать в игру Гооол!<br></div>
        <div class="startText">
        Цель игры забить как можно больше голов в ворота противника (слева) и постараться не пропустить голы в свои ворота (справа). Удар по мячу при помощи клика мыши вокруг мяча, чем дальше от мяча клик, тем сильнее удар.<br> Всё очень просто, надо только начать.
        </div>
      <button type="button" class="btn btn-primary startbtn">Начать игру</button>
      <a href="components/exit.php" class="btn btn-primary exit" type="button">Выход</a>
    </div>
     <div class="startModal results">
      <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
        <div><?=$_SESSION['nick']?> Ваш лучший результат <?=$_SESSION['score']?></div>
        <br>
        <table class="table">
          <tr>
            <td>Никнейм</td>
            <td>Результат</td>
          </tr>
        </table>
      <button type="button" class="btn btn-primary myClose">Закрыть</button>
    </div>
  </main>
  <script>
    "use strict";
    let id;
    const main = document.querySelector(".main");
    let coursorPosition;
    let moveToX, moveToY;
    let bollX, bollY, clickX, clickY, force, nextX, nextY, lengthFly;
    const plateSizeY = 740, plateSizeX = 1120; // Размер поля
    const forceCoef = 6; // Коэффицент силы удара, чем меньше, тем дальше летит мяч 
    const ballFlyTime = 600; // Коэффицент скорости мяча, чем больше, тем быстрее летит мяч
    const leftBorder = 38;
    const rightBorder = plateSizeX - 38;
    const topBorder = 40;
    const downBorder = plateSizeY;
    let oneTime = 1; // Время тайма в минутах
    let userCount = 0;
    let compCount = 0;
    let score = 0;
    const results = document.querySelector(".results"); 
    const schet = document.querySelector(".schet"); 
    const clock = document.querySelector(".clock"); 
    const start = document.querySelector(".start"); 
    let startbtn = document.querySelector(".startbtn");
    let CompManPosition = compMan.getBoundingClientRect();
    //let aboutClick = document.querySelector(".aboutclick");
    //aboutClick.onclick = () => {
    //  document.querySelector(".about").style.display = "block";
    //}
    let myClose = document.querySelectorAll(".myClose");
    for (let allClose of myClose){
      allClose.onclick = () => {
      //document.querySelector(".about").style.display = "none";
      results.style.display = "none";
      }
    }
    
    startbtn.onclick = () => startGame();
    //startGame();
    // --------------------   Начало игры    ------------------
     //bollone.addEventListener("transitionend", function(){flagEndTrans = 1});
    bollone.onclick = () => moveBoll(event);  
     
     
    function startGame() {
      start.style.display = "none";
      compManMove();
      countDown();
    }
   
    function moveBoll(event) {
      let bollPosition = bollone.getBoundingClientRect();
      bollX = bollPosition.left + 80; /* Положение мяча по Х*/
      bollY = bollPosition.top + 80;  /* Положение мяча по У*/
      clickX = event.clientX;  /* Положение клика по Х*/
      clickY = event.clientY;  /* Положение клика по У*/


      force = (Math.sqrt(((bollX - clickX) **2 + (bollY - clickY) **2)))/forceCoef; /* Вычисляем силу удара в зависимости от удаления клика от центра */
      moveToX = ((bollX - clickX) *force + bollX) -80; /* куда лететь по Х*/
      moveToY = ((bollY - clickY) *force + bollY) -80;  /* куда лететь по У*/
      screenControl(moveToX, moveToY); 
    } 
    
    function screenControl(posX, posY) {   //Определяем варианты вылета за пределы экрана
      
      if (lineOfFly(posX, posY)){          //Определяем, к какому краю лететь сперва 
        if (posX < leftBorder){             //Если мяч улетает за пределы левого экрана
          moveToX = leftBorder;
          if (moveToY > 310 && moveToY < 470) {
            moveToX = leftBorder - leftBorder;
            moveToY = newCalcFuncY(moveToX, bollX, bollY, posX, posY);
            return gool("left");
          }
          moveToY = newCalcFuncY(leftBorder, bollX, bollY, posX, posY);
          return goMove()
            .then(()=> {
              posX = Math.abs(posX) + leftBorder;
              return screenControl(posX, posY);
            });
        } else if (posX > rightBorder) {    //Если мяч улетает за пределы правого экрана
          moveToX = rightBorder;
           if (moveToY > 310 && moveToY < 470) {
            moveToX = rightBorder + leftBorder;
            moveToY = newCalcFuncY(moveToX, bollX, bollY, posX, posY); 
            return gool("right");
          }
          moveToY = newCalcFuncY(rightBorder, bollX, bollY, posX, posY);
          return goMove()
            .then(()=> {
              posX = rightBorder - (posX - rightBorder);
              return screenControl(posX, posY);
            });
        }
      } else {
        if (posY < topBorder) {             //Если мяч улетает за пределы верха
          moveToY = topBorder;
          moveToX = newCalcFuncX(topBorder, bollX, bollY, posX, posY);
         return goMove()
            .then(()=> {
              posY = Math.abs(posY) + topBorder;
              return screenControl(posX, posY);
            });
        } else if (posY > downBorder) {     //Если мяч улетает за пределы низа
          moveToY = downBorder;
          moveToX = newCalcFuncX(downBorder, bollX, bollY, posX, posY);
          return goMove()
            .then(()=> {
              posY = downBorder - (posY - downBorder);
              return screenControl(posX, posY);
            });
        }
      }      
      moveToX = posX;   //Если мяч улетает за пределы верха
      moveToY = posY;
      goMove() 
        .then(()=> {
          });
    }  

    function goMove() {                   //Процесс перемещения
       return new Promise(function(resolve,reject){
          lengthFly = Math.sqrt(((bollX - moveToX) **2 + (bollY - moveToY) **2));
          bollone.style.transitionDuration = lengthFly/ballFlyTime + "s"; //Устанавливаем время полета
          if (moveToX == leftBorder || moveToY == topBorder || moveToX == rightBorder|| moveToY == downBorder) {
            bollone.style.transitionTimingFunction = "linear";  //Изменяем тип перемещения в зависимости от того,
            } else {bollone.style.transitionTimingFunction = "ease-out";}  //был ли отскок от границы 
          bollone.style.left = moveToX +"px";
          bollone.style.top = moveToY +"px";
          bollX = moveToX;
          bollY = moveToY;
          //setInterval(() => {
          //let bollPosition = bollone.getBoundingClientRect()  
         // console.log(bollPosition.left);
         // console.log(bollPosition.top);
         // }, 10);
          //  let bollPosition = bollone.getBoundingClientRect();
        //    console.log(bollPosition.left)}
          bollone.ontransitionend = () => {
            bollone.ontransitionend = null;
            resolve();
          }
        })
    }
    
    function gool(pos) {
      return goMove()
         .then(()=> { 
           let firstUserCount = "0";
           let secondUserCount ="0";
           let firstCompCount = "0";
           let secondCompCount = "0";
          if (pos == "left") {
            userCount++;
            let goool = document.createElement("div");
            goool.className = "goool";
            goool.innerHTML = `
            Гооол!<br>
            Урааа!
            `;
            main.append(goool);
            setTimeout(() => goool.remove(), 1500);
          } else {
            compCount++;
            let goool = document.createElement("div");
            goool.className = "goool";
            goool.innerHTML = `
            Гооол!<br>
            `;
            main.append(goool);
            setTimeout(() => goool.remove(), 1500);
          }
        if (userCount < 10) {
          firstUserCount = "0";
          secondUserCount = String(userCount);
        } else {
          firstUserCount = String(userCount)[0];
          secondUserCount = String(userCount)[1];
        }
        if (compCount < 10) {
          firstCompCount = "0";
          secondCompCount = String(compCount);
        } else {
          firstCompCount = String(compCount)[0];
          secondCompCount = String(compCount)[1];
        }
        
        schet.innerHTML = `
        <img allign="center" src="img/${firstUserCount}.png" alt=""><img allign="center" src="img/${secondUserCount}.png" alt=""><img allign="center" src="img/points.png" alt=""><img allign="center" src="img/${firstCompCount}.png" alt=""><img allign="center" src="img/${secondCompCount}.png" alt="">
        `;  
        bollone.style.left = "560px";
        bollone.style.top = "390px";
      })
    }
    
    
    function countDown(){
      let s = 0;
      let zero = ""
      let count = setInterval(() => {
          if (s <= 0) {
            if (oneTime != 0) {
              oneTime--;
              s = 59;
            } else {
              clearInterval(count);
              return end();
            }
          } else s--;
          if (s < 10){
             zero = 0;
          } else zero = "";
          
          clock.innerHTML = `0${oneTime}:${zero}${s}`;
      } ,1000);
       

    }
    
    function end() {
      score = userCount - compCount;
      let end = document.createElement("div");
      end.className = "startModal end";
      end.innerHTML = `
        <button type="button" class="close myClose" onclick= "closes('end')" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        Конец тайма! Вы сыграли с счетом ${userCount} : ${compCount}<br>
        и набрали ${score} очков.
        <div><button type="button" class="btn btn-primary" onclick="startGame()">Сиграть ещё раз</button>
        <button type="button" class="btn btn-primary" onclick= "closes('end')">Выйти</button></div>
      
      `;
      
      main.append(end);
      let bodySend = new FormData();
      bodySend.append('score', score);
      fetch('components/sendscore.php', {
        method: 'POST',
        body: bodySend,
      })
        .then((response) => {
            if (response.ok) {
              return response.text(); 
            } else {
              console.error("Ошибка HTTP: " + response.status);
            }
          })
          .then((result) => {
            if(result.status == "fail") {
              alert(result.message);
            } else {
              console.log(result);
            }
          });
        
    }
    function closes(windcl) {
      let wind = `.${windcl}`;
      let close = document.querySelector(wind);
      close.remove();
    }
    
    function compManMove(){
      //let CompManPosition = compMan.getBoundingClientRect();
      setInterval(() => {
        let CompManPosition = compMan.getBoundingClientRect();
        let goManX = Math.random() * 1000;
        let goManY = Math.random() * 500;
        //console.log(goManX + "  " +goManY);
        compMan.style.transitionTimingFunction = "ease-out";
        compMan.style.transitionDuration = "4s";
        compMan.style.left = goManX + "px";
        compMan.style.top = goManY + "px";
        }, 4000);
    
    }
    
    function lineOfFly (X, Y) {    //Определяем, к какому краю лететь сперва, если возвращаем true,
      let calcYLeft = newCalcFuncY (leftBorder, bollX, bollY, X, Y);  //то летим сперва к боковым сторонам
      let calcYRight = newCalcFuncY (rightBorder, bollX, bollY, X, Y);

      if (X < bollX && calcYLeft > topBorder && calcYLeft < downBorder) {
        return true 
      } else if (X > bollX && calcYRight > topBorder && calcYRight < downBorder) {
        return true 
      } else return false
    }

    function newCalcFuncY (x, firstX, firstY, secondX, secondY){  //Расчет точки остоновки по оси У, зная Х
      let k = (firstY - secondY) / (firstX - secondX);
      let b = secondY - k * secondX;
      let y = k * x + b;
      return y;
    }

    function newCalcFuncX (y, firstX, firstY, secondX, secondY){  //Расчет точки остоновки по оси Х, зная У
      let k = (firstY - secondY) / (firstX - secondX);
      let b = secondY - k * secondX;
      let x = (y - b) / k;
      return x;
    }
    
    function scores() {
      fetch("components/score.php")
          .then((response) => {
            if (response.ok) {
              return response.json(); 
            } else {
              console.error("Ошибка HTTP: " + response.status);
            }
          })
          .then((result) => {
            if(result.status == "fail") {
              alert(result.message);
            } else {
              createRows(result);
            }
          });
          results.style.display = "block";
    }  
      
      
    function createRows(players) {
        let table = document.querySelector(".table");
        for(let player of players) {
          let row = document.createElement("tr");
          row.innerHTML = `
            <td>${player.nick}</td>
            <td>${player.score}</td>
          `;
          table.append(row);
        
        }
      }  
    function about() {
      let about = document.createElement("div");
      about.className = "startModal about";
      about.innerHTML = `
        <button type="button" class="close" data-dismiss="modal" onclick= "closes('about')" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="aboutText">Всем привет!<br>
          Меня зовут Дмитрий и это моя первая игра написаная на Java Script.
          (не судите строго)<br>
          Все вопросы и пожелания отправляйте мне на мейл: <a href="mailto:wamp@mail.ru">wamp@mail.ru</a>
          </div>
        <button type="button" onclick= "closes('about')" class="btn btn-primary">Закрыть</button>
      `;
      main.append(about);
    }  
      
      
      
      
      

        
  </script>
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>