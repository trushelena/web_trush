<?php
session_start(); // начало сессии: если сессии еще нет 
// (не пришел Cookie "PHPSESSID" или нет файла сессии, 
//  соответствующего значению cookie "PHPSESSID"), то:
//  1) генерируется уникальный идентификатор сессии;
//  2) устанавливается Cookie "PHPSESSID" со значением этого идентификатора
//  3) создается файл сессии с соответствующим идентификатору именем
//  4) инициализируется суперглобальный массив $_SESSION, который проецируется на файл сессии

// Проверяем, был ли уже установлен Cookie 'Mortal',
// Если да, то читаем его значение,
// И увеличиваем значение счетчика обращений к странице:
if (isset($_COOKIE['index'])) $cnt=$_COOKIE['index']+1;
else $cnt=0;
// Устанавливаем Cookie 'Mortal' зо значением счетчика,
// С временем "жизни" до 18/07/29,
// То есть на очень долгое время:
setcookie("index",$cnt,0x6FFFFFFF);
// Выводит число посещений (загрузок) этой страницы:


//--- конфигурационные параметры ---
$db_drivername = "mysql";
$hostname = "localhost";
$dbname = "web_trush";
$username = "root";
$password = "";
//--- Создание PDO для соединения с сервером БД ---
$pdo = new PDO("{$db_drivername}:host={$hostname};dbname={$dbname}", $username, $password);
//--- 1 параметр PDO: "mysql:host=localhost;dbname=weblabdb"
//--- 2 параметр PDO: "root"
//--- 3 параметр PDO: ""
$pdo->query("SET CHARACTER SET utf8"); // установка кодировки символов для текущего соединения с MySQL Server

require_once 'blocks/auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<link rel="shortcut icon" href="img/logo_1.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script type="text/javascript" src="js/jquery.js"></script>
<meta charset="utf-8">
<title>
<?php
                $url = '\'' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '\'';
                $menu_item_result = $pdo->query("SELECT * FROM  `pages` WHERE url=" . $url);
                if ($menu_item_result->rowCount() > 0) {
                    $menu_item = $menu_item_result->fetch(PDO::FETCH_ASSOC);
                    echo $menu_item['name'];
                } else {
                    echo 'Page 404 - Страница не найдена!';
                }
                ?>
</title>
</head>
<body>
	<div id="main-page">
		<div id="header-part">
			<?php include 'blocks/header.php' ?>
		</div>

		<div id="horizontal-menu">
			<ul>
				<?php include 'blocks/menu.php' ?>
			</ul>
		</div>

		<div id="main-content">
                <?php include 'blocks/auth_form.php' ?>
                <?php
                $url = '\'' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '\'';
                $menu_item_result = $pdo->query("SELECT * FROM  `pages` WHERE url=" . $url);
                if ($menu_item_result->rowCount() > 0) {
                    $menu_item = $menu_item_result->fetch(PDO::FETCH_ASSOC);
                    echo $menu_item['content'];
                } else {
                    echo 'Page 404 - Страница не найдена!';
                }
                ?>
          </div>
		 
		<div id="adv-banners">
			<p>
				<?php include 'blocks/adv-banners.php' ?>
			</p>
		</div>

		<div id="copyright">
			<?php echo '<p>Количество посещений: ';
				echo  $cnt; 
				echo ' раз(a)</p>';
				?>
			<p>&copy;</p></div>
	</div>
</body>

</body>
</html>

