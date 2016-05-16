<?php
$B["Hobby"] = array("href" => "http://www.vkyc.ru/hobbi.html", "src" => "img/1.jpg", "alt" => "Хобби");
$B["ForKids"] = array("href" => "http://www.7ya.ru/pub/leisure/", "src" => "img/2.jpg", "alt" => "Для детей");
$B["Lifehacker"] = array("href" => "http://lifehacker.ru/2015/06/12/12-hobbies/", "src" => "img/3.png", "alt" => "Лайфхакер");

foreach ($B as $adv) {
    echo '<a href="'.$adv["href"].'"><img src="'.$adv["src"].'" width="100" height="50" alt="'.$adv["alt"].'"></a>';
}