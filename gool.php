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
    
    .ring {
      position: absolute;
      left: 10px;
      top: 100px;
      border: 2px solid black;
      padding: 0 60px;
    }
     #bollone {
      /*content: "";*/
      display: inline-block;
      position: absolute;
      padding: 80px;
      left: 300px;
      top: 400px;
      background-color: gray;
      border-radius: 50%;
      transition: all 0.5s cubic-bezier(.17,.67,.83,.67);
      /*transition: left 5s cubic-bezier(.17,.67,.83,.67), top 5s cubic-bezier(.17,.67,.83,.67);*/
      z-index: 1;
    }
   /* #bollone:active {
      left: 600px;
      top: 100px; 
    }*/
    
    .boll {
      display: inline-block;
      position: absolute;
      top: 40px;
      left: 40px; 
      padding: 40px;
      background-color: blue;
      border-radius: 50%;
      transition: left ease 1000ms;
      z-index: 10;
    }
    
    /*.top {
      position: absolute;
      width: 80px;
      height: 40px;
      left: 0;
      top: -40px;
      background-color: gray;}
      
    .top:after {
      content: "";
      position: absolute;
      width: 80px;
      height: 40px;
      left: 0;
      top: 120px;
      background-color: gray;}
      
    .boll:active:before {
      left: 1000px;
    }  */
    
  </style>
</head>
<body>
  
  <div class="ring"></div>
  
  <div id="bollone" class="bollaura">
    <div class="boll">
    
    </div>
  </div>
  
  <script>
    "use strict";
    let coursorPosition;
    /*let bollPosition = bollone.getBoundingClientRect();
    let bollX = bollPosition.left + 80;
    let bollY = bollPosition.top + 80;*/
    /*console.log(bollX + " " + bollY);*/
    bollone.addEventListener("mousedown", function(event) {
      console.log(event.clientX + " " + event.clientY);
      let bollPosition = bollone.getBoundingClientRect();
      let bollX = bollPosition.left; /*+ 80;*/
      console.log("boll x =" + bollX);
      let bollY = bollPosition.top;  /*+ 80;*/
      console.log("boll Y =" + bollY);
      let clickX = event.clientX - 80;
      let clickY = event.clientY - 80;
      let force = (Math.sqrt(((bollX - clickX) **2 + (bollY - clickY) **2)))/10;
      console.log("сила =" + force);
      /*console.log("Вычисление по Х = (" + bollX +"-"+ event.clientX+ ")+ " + bollX + "** 1.05 =" + ((bollX - event.clientX) + bollX)**1.05 + "- 80");*/
      
      let mooveToX = ((bollX - clickX) *force + bollX);
      if (mooveToX < 0) { 
        bollone.style.left = "0";
        mooveToX *= -1;}
      bollone.style.left = mooveToX +"px";
      /*console.log("перемещаем по Х" + bollone.style.left);*/
      let mooveToY = ((bollY - clickY) *force + bollY);
      if (mooveToY < 0) { 
        bollone.style.top = "0";
        mooveToY *= -1;}
      bollone.style.top = mooveToY +"px";
      /*console.log("перемещаем по У" + bollone.style.top);*/
    
      /*console.log(bollone.style.top); */
    }); 
    /*
    bollone.addEventListener("mouseup", function(event) {
      console.log(event.clientX + " " + event.clientY);
      bollone.style.top = event.clientY+80+"px";
      bollone.style.left = event.clientX+80+"px";
      console.log(bollone.style.top); 
    }); */
    function mooveBoll (){
      let k = (bollY - clickY) / (bollX - clickX);
      let b = clickY -k * clickX;
      let y = k * x + b;
      
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