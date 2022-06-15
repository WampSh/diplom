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
    margin: 0;
    height: 800px;
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
    
    .vorotar {
      display: block;
      position: absolute;
      left: 1145px;
      top: 340px;
      z-index: 70;
    }

    .vorotal img, .vorotar img {
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
      background-color: white;  /*Убрать*/
      border-radius: 50%;
      transition: all 0.5s ease-out;
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
      /*transition: left ease plateSizeXms;*/
      z-index: 50;
    }
    
  </style>
</head>


<body>
  <header class="head">
    <div class="schet"></div>
  </header>
  <img class="plate" src="./img/footbolplate.jpeg" width="1250px" height="800px" alt="">
  
  <div class="vorotal"><img src="./img/vorotal.png" alt=""></div>
  <div class="vorotar"><img src="./img/vorotar.png" alt=""></div>
  
  <div id="bollone" class="bollaura">
    <div class="boll"><img src="./img/ball.svg" width="60px" height="60px" alt="">
    
    </div>
  </div>
  
  <script>
    "use strict";
    let coursorPosition;
    let moveToX, moveToY;
    let bollX, bollY, clickX, clickY, force, nextX, nextY, lengthFly;
    let plateSizeY = 740, plateSizeX = 1100;

    bollone.addEventListener("click", moveBoll); 
    
   
   
    function moveBoll(event) {
      let bollPosition = bollone.getBoundingClientRect();
      bollX = bollPosition.x; /* Положение мяча по Х*/
      bollY = bollPosition.y;  /* Положение мяча по У*/
      
      console.log(bollPosition);
      console.log("mouse on "+ event.clientX + " " + event.clientY); /* Вывод в консоль Положение клика мыши */
      console.log("boll on x =" + bollX); /* --------Вывод в консоль Положение мяча по Х*/
      console.log("boll on Y =" + bollY); /* --------Вывод в консоль Положение мяча по У*/
      
      clickX = event.clientX - 80;  /* Положение клика по Х*/
      clickY = event.clientY - 80;  /* Положение клика по У*/
      force = (Math.sqrt(((bollX - clickX) **2 + (bollY - clickY) **2)))/10; /* Вычисляем силу удара (дальность полета мяча) в зависимости от удаления клика от центра */
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
      if (posX > plateSizeX){
        nextX = plateSizeX - (moveToX - plateSizeX);
        nextY = moveToY;
        moveToX = plateSizeX;
        moveToY = calcFuncX(moveToX);
      }
      if (posY > plateSizeY) {         
        nextY = plateSizeY - (moveToY - plateSizeY);
        nextX = moveToX;
        moveToY = plateSizeY;
        moveToX = calcFuncY(moveToY);
      }
      //console.log("First " + bollone.style.left +"px" + bollone.style.top +"px" );
      goMove();
      //console.log("First " + bollone.style.left +"px" + bollone.style.top +"px" );
      
      if (moveToX == 0 || moveToX == plateSizeX || moveToY == 0 || moveToY == plateSizeY) {
        moveToX = nextX;
        moveToY = nextY;
        bollone.addEventListener("transitionend", goMove, false); 
      }  
    }  
    
    function goMove() {
      lengthFly = Math.sqrt(((bollX - moveToX) **2 + (bollY - moveToY) **2));
      bollone.style.transitionDuration = lengthFly/400 + "s";
      if (moveToX == 0 || moveToY == 0 || moveToX == plateSizeX || moveToY == plateSizeY) {
        bollone.style.transitionTimingFunction = "linear";
        } else {bollone.style.transitionTimingFunction = "ease-out";}
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