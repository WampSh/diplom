<!-- ?
//session_start();
//header('Content-Type: text/html; charset=utf-8');
//  if (isset($_SESSION['id'])) {
//    exit('logok');
//} -->

<!doctype html>
<html lang="ru">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <meta charset="UTF-8">
  <title>Футбол</title>
  <style>
    body {
    position: relative;
    top: 0;
    left: 0;
    margin: 0;
    height: plateSizeXpx;
    width: 1250px;
    
    }
    
    .schet {
      height: 50px;
      background-color: rgb(21, 92, 11);
    }
    
    .plate {
      z-index: 0;
    }
    
    .vorotal {
      display: block;
      position: absolute;
      left: 5px;
      top: 340px;
      z-index: 70;
    }

    .vorotal img {
      height: 220px;
      width: 100px;
    }

     #bollone {
      /*content: "";*/
      display: block;
      position: absolute;
      padding: 80px;
      left: 550px;
      top: 370px;
      /* background-color: white; */
      border-radius: 50%;
      /* transition: all 0s ease-out; */
      z-index: 0;
      cursor: pointer;
    }
   
    .boll {
      display: inline-block;
      position: absolute;
      top: 50px;
      left: 50px;  
      /*padding: 40px;
      background-color: blue;*/
      border-radius: 50%;
      /* transition: left ease plateSizeXms; */
      z-index: 50;
    }
    .startModal {
      height: 350px;
      width: 500px;
      background-color: lightblue;
      position: absolute;
      padding: 20px;
      top: calc(50% - 300px);
      left: calc(50% - 200px);
      text-align: center;
      border-radius: 1em;
      
    }

    .bl {
      display: block;
      text-align: left;
      line-height: 1.5em;
    }

    .regprig, .inprig {
      text-decoration: underline;
      color: blue; 
      cursor: pointer;     
    }
    .formClass {
      align-self: center;
      padding: 0, 30px;
    }
    .hide {
      display: none;
    }
    .down {
      position: absolute; 
      bottom: 5px;
      margin: 5px;
      align-self: auto;
    }
    
  </style>
</head>


<body>
  <header class="head">
    <div class="schet"></div>
  </header>
  <img class="plate" src="./img/footbolplate.jpeg" width="1250px" height="800px" alt="">
  
  <div class="vorotal"><img src="./img/vorotal.png" alt=""></div>
  
  <div id="bollone" class="bollaura">
    <div class="boll"><img src="./img/ball.svg" width="60px" height="60px" alt="">
    
    </div>
  </div>
  <div class="startModal">
    <h3>Добро пожаловать в игру ГОООЛ!</h3>
    <h4 class="hello"></h4>
 
    <form action="auth.php" class="auth" method="POST">
      <div class="formClass form-group">
        <span class="bl">Ваш никнейм:</span>
        <input class="login form-control form-control-sm" type="text" name="nick" placeholder="Введите никнейм">
        <span class="bl">Ваш пароль:</span>
        <input type="password" class="pass form-control form-control-sm" name="password" placeholder="Введите пароль">
        <span class="bl hide">Повторите пароль:</span>
        <input type="password" class="hide form-control form-control-sm" name="password" placeholder="Повторите пароль">
        <div class="alert"></div>
        <div class="down">
          <button class="bl btn btn-primary" type="submit"></button>
          <div class="registr bl">Если Вы впервый раз у нас, <span class="regprig">зарегистрируйтесь</span></div>
          <div class="hide bl">Если Вы уже играли, просто <span class="inprig">авторизуйтесь</span></div>
        </div>
      </div>
    </form>
  </div>
  <script>
    "use strict";
    let coursorPosition;
    let moveToX, moveToY;
    let bollX, bollY, clickX, clickY, force, nextX, nextY, lengthFly;
    let plateSizeY = 740, plateSizeX = 1120; // Размер поля
    let forceCoef = 6; // Коэффицент силы удара, чем меньше, тем дальше летит мяч 
    let ballFlyTime = 600; // Коэффицент скорости мяча, чем больше, тем быстрее летит мяч
    let leftBorder = 0;
    let rightBorder = plateSizeX;
    let topBorder = 0;
    let downBorder = plateSizeY;
    
    let buttText = document.querySelector(".btn");
    buttText.innerHTML = 'Войти';
    let regPrig = document.querySelector(".regprig");
    regPrig.onclick = () => changeReg();
    let inPrig = document.querySelector(".inprig");
    inPrig.onclick = () => changeIn();
    let alertst = document.querySelector(".alert");
    let hello = document.querySelector(".hello");
    hello.innerHTML= "Пожалуйста авторизуйтесь:";
    let registr = document.querySelector(".registr");
    let showSecondPass = document.querySelectorAll(".hide");
    let subForm = document.querySelector(".auth");
    subForm.onsubmit = function(event) {
      event.preventDefault();
      sendForm(this);
    }

    function changeReg() {
      buttText.innerHTML = "Зарегистрироваться";
      hello.innerHTML= "Зарегистрируйтесь:";
      registr.style.display = "none";
      for (let all of showSecondPass){
        all.style.display = "block";
        //all.style.display =
      }
    }
    function changeIn() {
      buttText.innerHTML = "Войти";
      registr.style.display = "block";
      hello.innerHTML= "Пожалуйста авторизуйтесь:";
      for (let all of showSecondPass){
        all.style.display = "none";
        //all.style.display =
      }
    }
    
    function sendForm(form) {
      let sendData = new FormData(form);
      fetch("auth.php", {
        method: form.method,
        body: sendData
      })
        .then((response) => {
            if (response.ok) {
              return response.text();
            } else {
              alertst.innerHTML = `Ошибка соединения с базой ${response.status}`;
            }
          })
        .then((result) => {
          if (result == "sucsess") {

          } else if (result == "empty") {
            alertst.innerHTML = "Не все поля заполнены";
          } else if (result == "wrong") {
            alertst.innerHTML = "Проверьте правильность ника и пароля";
          } else alertst.innerHTML = `Ошибка: ${result}`;
        })
    }

    // --------------------   Начало игры    ------------------
     //bollone.addEventListener("transitionend", function(){flagEndTrans = 1});
     bollone.onclick = () => moveBoll(event);    

   
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
          moveToY = newCalcFuncY(leftBorder, bollX, bollY, posX, posY);
          return goMove()
            .then(()=> {
              posX = Math.abs(posX);
              return screenControl(posX, posY);
            });
        } else if (posX > rightBorder) {    //Если мяч улетает за пределы правого экрана
          moveToX = rightBorder;
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
              posY = Math.abs(posY);
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
      goMove(); 
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
          bollone.ontransitionend = () => {
            bollone.ontransitionend = null;
            resolve();
          }
        })

      
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
    
    
        
  </script>
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>