<div class="startModal mymodal">
    <h3>Добро пожаловать в игру ГОООЛ!</h3>
    <h4 class="hello"></h4>
 
    <form action="components/auth.php" class="auth" method="POST">
      <div class="formClass form-group">
        <span class="bl">Ваш никнейм:</span>
        <input class="login form-control form-control-sm" type="text" name="nick" placeholder="Введите никнейм">
        <span class="bl">Ваш пароль:</span>
        <input type="password" class="pass form-control form-control-sm" name="password" placeholder="Введите пароль">
        <span class="bl hide">Повторите пароль:</span>
        <input type="password" class="hide secondpas form-control form-control-sm" name="secpassword" placeholder="Повторите пароль">
        <div class="alert"></div>
        <div class="down">
          <button class="btnin bl btn btn-primary ml-2" type="submit"></button>
          <div class="registr bl">Если Вы в первый раз у нас, <span class="regprig">зарегистрируйтесь</span></div>
          <div class="hide bl">Если Вы уже играли, просто <span class="inprig">авторизуйтесь</span></div>
        </div>
      </div>
    </form>
  </div>
    <script>
    "use strict";
    let flagreg = 0;
    let buttText = document.querySelector(".btnin");
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
    let modal = document.querySelector(".mymodal");
    subForm.onsubmit = function(event) {
      event.preventDefault();
      sendForm(this);
    }

    function changeReg() {
      flagreg = 1;
      buttText.innerHTML = "Зарегистрироваться";
      hello.innerHTML= "Зарегистрируйтесь:";
      registr.style.display = "none";
      alertst.innerHTML = "";
      for (let all of showSecondPass){
        all.style.display = "block";
      }
    }
    function changeIn() {
      flagreg = 0;
      buttText.innerHTML = "Войти";
      registr.style.display = "block";
      hello.innerHTML= "Пожалуйста авторизуйтесь:";
      alertst.innerHTML = "";
      for (let all of showSecondPass){
        all.style.display = "none";
      }
    }
    
    function sendForm(form) {
      let sendData = new FormData(form);
      (flagreg == 1)? sendData.append("reg", "on"): sendData.append("reg", "off");
        fetch("components/auth.php", {
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
          if (result == "sucsess" ) {
            modal.style.display = "none";
            const nick = document.querySelector(".username");
            let login = document.querySelector(".login");
            nick.innerHTML = login.value.toUpperCase();

          } else if (result == "empty") {
            alertst.innerHTML = "Не все поля заполнены";
          } else if (result == "noequil") {
            alertst.innerHTML = "Пароли не совпадают";
          } else if (result == "wrong") {
            alertst.innerHTML = "Проверьте правильность ника и пароля";
          } else if (result == "lessfore") {
            alertst.innerHTML = "Пароль должен быть не менее четырех символов";
          } else if (result == "allready") {
            alertst.innerHTML = "Пользователь с таким ником уже есть";
          } else alertst.innerHTML = `Ошибка: ${result}`;
        })
    }
  </script>