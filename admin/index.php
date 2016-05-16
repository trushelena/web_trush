<?php
session_start(); // начало сессии: если сессии еще нет 
// (не пришел Cookie "PHPSESSID" или нет файла сессии, 
//  соответствующего значению cookie "PHPSESSID"), то:
//  1) генерируется уникальный идентификатор сессии;
//  2) устанавливается Cookie "PHPSESSID" со значением этого идентификатора
//  3) создается файл сессии с соответствующим идентификатору именем
//  4) инициализируется суперглобальный массив $_SESSION, который проецируется на файл сессии

require_once 'config.php'; // обязательное включение конфигурации
//--- Создание PDO для соединения с сервером БД ---
$pdo = new PDO("{$db_drivername}:host={$hostname};dbname={$dbname}", $username, $password);
//--- 1 параметр PDO: "mysql:host=localhost;dbname=weblabdb"
//--- 2 параметр PDO: "root"
//--- 3 параметр PDO: ""
$pdo->query("SET CHARACTER SET utf8"); // установка кодировки символов для текущего соединения с MySQL Server

require_once 'classes/pagesClass.php'; // включаем класс страниц
require_once 'classes/userClass.php'; // включаем класс пользователей
require_once 'blocks/auth.php'; // единоразовое включение обязательного файла авторизации
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Панель администрирования</title>
    <link rel="shortcut icon" href="../img/logo_1.jpg">
    <link type="text/css" rel="stylesheet" href="../css/screen.css" />
  </head>
  <body>
    <?php if (isset($_SESSION["name"])) { ?>
      <div id="header">Панель администрирования</div>
      <div id="midle">
        <div id="left_bar">
          <h2><?php echo $_SESSION["name"]; ?></h2>
          <form method="post">
            <input class="btn" value="Выход" type="submit" name="exit" />
          </form>
          <?php include 'blocks/menu.php'; ?>
        </div>
        <div id="content">
          <?php
          if (isset($_GET['obj'])) {
            $file_name_manag = 'blocks/' . $_GET['obj'] . '_manag.php';
            if (file_exists($file_name_manag)) {
              include_once $file_name_manag;
            } else {
              echo 'Не найден файл управления ' . $file_name_manag;
              echo '<br /> Его необходимо реализовать';
            }
          }
          ?>
        </div>
      </div>
      <?php
    } else {
      include 'blocks/auth_form.php';
    }
    ?>
    <div id="footer"><a href="../">Перейти к общедоступной части сайта (frontend)</a></div>
  </body>
</html>
