<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Футбол</title>
  <style>
    body {
    position: relative;
    top: 0;
    left: 0;
    
    }
    
    .head {
      min-height: 30%;
    }
    
    .plate {
      z-index: 45;
    }
    
    .ring {
      position: absolute;
      left: 10px;
      top: 100px;
      border: 2px solid black;
      padding: 0 60px;
      z-index: 100;
    }
     #bollone {
      /*content: "";*/
      display: block;
      position: absolute;
      padding: 80px;
      left: 300px;
      top: 400px;
      /*background-color: white;*/
      border-radius: 50%;
      transition: all 0.5s cubic-bezier(0, 0, .58, 1);
      z-index: 0;
      cursor: pointer;
    }
   
    .boll {
      display: inline-block;
      position: absolute;
      top: 40px;
      left: 40px; 
      /*padding: 40px;
      background-color: blue;*/
      border-radius: 50%;
      transition: left ease 1000ms;
      z-index: 50;
    }
    
  </style>
</head>


<body>
  <header class="head"></header>
  <img class="plate" src="./img/footbolplate.jpeg" width="100%" height="600px" alt="">
  <div class="ring"></div>
  
  <div id="bollone" class="bollaura">
    <div class="boll"><img src="./img/ball.svg" width="80px" height="80px" alt="">
    
    </div>
  </div>
  
  <script>
    "use strict";
    let coursorPosition;
    let moveToX, moveToY;
    let bollX, bollY, clickX, clickY, force, nextX, nextY;
    bollone.addEventListener("mousedown", moveBoll); 
    
   
   
    function moveBoll(event) {
      let bollPosition = bollone.getBoundingClientRect();
      console.log("mouse on "+ event.clientX + " " + event.clientY); /* Вывод в консоль Положение клика мыши */
      bollX = bollPosition.left; /* Положение мяча по Х*/
      console.log("boll on x =" + bollX); /* --------Вывод в консоль Положение мяча по Х*/
      bollY = bollPosition.top;  /* Положение мяча по У*/
      console.log("boll on Y =" + bollY); /* --------Вывод в консоль Положение мяча по Х*/
      clickX = event.clientX - 80;  /* Положение клика по Х*/
      clickY = event.clientY - 80;  /* Положение клика по У*/
      force = (Math.sqrt(((bollX - clickX) **2 + (bollY - clickY) **2)))/10; /* Вычисляем силу удара в зависимости от удаления клика от центра */
      console.log("сила =" + force);    /* --------Вывод в консоль силы */
      // ------------ 
      moveToX = ((bollX - clickX) *force + bollX); /* куда лететь по Х*/
      moveToY = ((bollY - clickY) *force + bollY);  /* куда лететь по У*/
      
      screenControl(moveToX, moveToY); 
      
      /*if (moveToX < 0) {         
        console.log("Menee 0 " + moveToX);
        lessX = Math.abs(moveToX);
        moveToX = "0";
        bollone.style.left = moveToX +"px";
        bollone.addEventListener("transitionend", lessZiroX); 
      }
      bollone.style.left = moveToX +"px";
      
      
      
      if (moveToY < 0) {         
        console.log("Menee 0 " + moveToY);
        lessY = Math.abs(moveToY);
        moveToY = "0";
        bollone.style.left = moveToY +"px";
        bollone.addEventListener("transitionend", lessZiroY); 
      }
      bollone.style.top = moveToY +"px";*/

    }; 
    
    
    function screenControl(posX, posY) {
      let flag = 0;
      if (posX < 0){
        nextX = Math.abs(moveToX);
        nextY = moveToY;
        moveToX = 0;
        moveToY = calcFuncX(moveToX);
      }
      if (posY < 0) {         
        nextY = Math.abs(moveToY);
        nextX = moveToX;
        moveToY = 0;
        moveToX = calcFuncY(moveToY);
      }
      if (posX > 1000){
        nextX = 1000 - (moveToX - 1000);
        nextY = moveToY;
        moveToX = 1000;
        moveToY = calcFuncX(moveToX);
      }
      if (posY > 500) {         
        nextY = 500 - (moveToY - 500);
        nextX = moveToX;
        moveToY = 500;
        moveToX = calcFuncY(moveToY);
      }
      console.log("First " + bollone.style.left +"px" + bollone.style.top +"px" );
      goMove();
      console.log("First " + bollone.style.left +"px" + bollone.style.top +"px" );
      
      if (moveToX == 0 || moveToX == 1000 || moveToY == 0 || moveToY == 500) {
        moveToX = nextX;
        moveToY = nextY;
        bollone.addEventListener("transitionend", goMove, true); 
      }  
    }  
    
    function goMove() {
      bollone.style.left = moveToX +"px";
      bollone.style.top = moveToY +"px"; 
      
    }
    
    
    function lessZiroX() {
      
      console.log("after + " + moveToX);
      bollone.style.left = nextX +"px"; 
      bollone.removeEventListener("transitionend", lessZiroX); 
    }
    
    function lessZiroY() {
      
      console.log("after + " + moveToY);
      bollone.style.top = nextY +"px"; 
      bollone.removeEventListener("transitionend", lessZiroY); 
    }
    /*
    bollone.addEventListener("mouseup", function(event) {
      console.log(event.clientX + " " + event.clientY);
      bollone.style.top = event.clientY+80+"px";
      bollone.style.left = event.clientX+80+"px";
      console.log(bollone.style.top); 
    }); */
    function calcFuncX (x){
      let k = (bollY - clickY) / (bollX - clickX);
      let b = clickY -k * clickX;
      let y = k * x + b;
      return y;
    }
    
    function calcFuncY (y){
      let k = (bollY - clickY) / (bollX - clickX);
      let b = clickY -k * clickX;
      let x = (y - b) / k;
      return x;
    }
    
    
    /*let boolPath = document.querySelector(".bollaura");
    boolPosition =boolPath.getBoundingClientRect();
    bollone.onclick = function(event) {
      
    };*/
    
    /*function placeClick(event) {
      alert(event.clientX);
    }*/
    //alert(" ");
    //boolPosition.left = 200;
    
    
    
  </script>
  
</body>
</html>