<div id="auth_block" class="module">
  <?php
  if (isset($_SESSION["name"])) {
    ?>
    <h2>Здравствуйте, <?php echo $_SESSION["name"]; ?></h2>
    <form method="post">
      <a class="btn btn-primary" href="admin/">Панель администрирования</a>
      <input class="btn btn-default" value="Выход" type="submit" name="exit" />
    </form>
  <?php } else { ?>    
    <span class="err"><h2>Авторизация</h2><?php echo $message_err; ?></span>

    <!--<form >
      <input name="name" type="text" placeholder="Логин" size="20"/>
      <input name="pass" type="password" placeholder="Пароль" size="20"/>
      <input class="btn" type="submit" value="Ok"/>
    </form>-->
<form class="form-inline" method="post">
       <div class="form-group">
          <label for="logininput">Логин:</label>
          <input name="name" type="text" class="form-control" id="logininput" placeholder="Login">
      </div>
      <div class="form-group">
          <label for="passwordinput">Пароль:</label>
          <input name="pass" type="password" class="form-control" id="passwordinput" placeholder="Password">
      </div>
  <button type="submit" class="btn btn-default">OK</button>
</form>
    <?php
  }
  ?>
</div>

