"use strict";
let id;
const main = document.querySelector(".main");
let coursorPosition;
let moveToX, moveToY;
let bollX, bollY, clickX, clickY, force, nextX, nextY, lengthFly;
const plateSizeY = 740, plateSizeX = 1120; // Размер поля
const forceCoef = 6;        // Коэффицент силы удара, чем меньше, тем дальше летит мяч 
const ballFlyTime = 600;    // Коэффицент скорости мяча, чем больше, тем быстрее летит мяч
const leftBorder = 38;                // Отскок слева
const rightBorder = plateSizeX - 38; // Отскок справа
const topBorder = 40;                 // Отскок сверху
const downBorder = plateSizeY;        // Отскок снизу
let oneTime = 1; // Время тайма в минутах
let userCount = 0; //Начальный счет
let compCount = 0; //Начальный счет
let score = 0;     //Начальные очки
const bollone = document.querySelector(".bollone");
const results = document.querySelector(".results"); 
const schet = document.querySelector(".schet"); 
const clock = document.querySelector(".clock"); 
const start = document.querySelector(".start"); 
let startbtn = document.querySelector(".startbtn");
const compMan = document.querySelector(".compMan");
let CompManPosition = compMan.getBoundingClientRect();
let moveMan;
//let myClose = document.querySelectorAll(".myClose");
//let alltr = document.querySelectorAll(".temptr");
//for (let allClose of myClose){
  //allClose.onclick = () => {
  //  results.style.display = "none";
  //  alltr.remove();
    
  //}
//}

// --------------------   Начало игры    ------------------
//startbtn.onclick = () => startGame();
bollone.onclick = () => moveBoll(event);  

 
 
function startGame() {
  start.style.display = "none";
  compManMove();
  countDown(oneTime);
}

function moveBoll(event) {
  let bollPosition = bollone.getBoundingClientRect();
  bollX = bollPosition.left + 80; /* Положение мяча по Х*/
  bollY = bollPosition.top + 80;  /* Положение мяча по У*/
  clickX = event.clientX;  /* Положение клика по Х*/
  clickY = event.clientY;  /* Положение клика по У*/
  force = (Math.sqrt((bollX - clickX) **2 + (bollY - clickY) **2))/forceCoef; /* Вычисляем силу удара в зависимости от удаления клика от центра */
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
        message();
      } else {
        compCount++;
        message();
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

function message(){
  let goool = document.createElement("div");
  goool.className = "goool";
  goool.innerHTML = `Гооол!`;
  main.append(goool);
  setTimeout(() => goool.remove(), 1500);
} 

function countDown(min){
  let s = 0;
  let zero = ""
  let count = setInterval(() => {
    if (s <= 0) {
      if (min !== 0) {
        min--;
        s = 59;
      } else {
        clearInterval(count);
        clearInterval(moveMan);
        return end();
      }
    } else s--;
    if (s < 10){
       zero = 0;
    } else zero = "";
    clock.innerHTML = `0${min}:${zero}${s}`;
  } ,1000);
}

function end() {
  score = userCount - compCount;
  let end = document.createElement("div");
  end.className = "startModal end";
  end.innerHTML = `
    <button type="button" class="close" onclick="closes('end')" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    Конец тайма! Вы сыграли с счетом ${userCount} : ${compCount}<br>
    и набрали ${score} очков.
    <div><button type="button" onclick= "restartGame()" class="btn btn-primary" >Сиграть ещё раз</button>
    <button type="button" class="btn btn-primary" onclick="closes('end')">Выйти</button></div>
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
          console.error(result.message);
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

function restartGame() {
  closes('end');
  compManMove();
  countDown(oneTime);
}

function compManMove(){
  moveMan = setInterval(() => {
    let CompManPosition = compMan.getBoundingClientRect();
    let goManX = Math.random() * 1000;
    let goManY = Math.random() * 500;
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
        createPage(result);
      }
    });
} 

function createPage(players) {
  let newTable = "";
  for(let player of players) {
    newTable += `
      <tr>
        <td>${player.nick}</td>
        <td>${player.score}</td>
      </tr>
  `;}
  let scorePage = document.createElement("div");
  scorePage.className = "startModal results";
  scorePage.innerHTML = `
    <button type="button" class="close" data-dismiss="modal" onclick= "closes('results')" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
      <div>Лучшие результаты</div>
      <br>
      <table class="table">
        <tr>
          <td>Никнейм</td>
          <td>Результат</td>
        </tr>
        ${newTable}
      </table>
    <button type="button" onclick= "closes('results')" class="btn btn-primary">Закрыть</button>
  `;
  main.append(scorePage);
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
