<?php

/**
 * Класс pageClass
 * предназначен для работы с таблицей страниц (pages)
 *
 * @author Труш Е.Н.
 */
class pagesClass {

  /**
   * соединение с БД
   *
   * @var classPDO
   */
  private $pdo;

  /**
   * Наименование таблицы в БД
   *
   * @var string
   */
  private $table = 'pages';

  /**
   * Конструктор получает соединение (объект PDO) с сервером БД
   * и помещает его в частное свойство для функционирования
   * остальных методов класса (объекта)
   *
   * @param classPDO $pdo
   */
  function __construct($pdo) {
    if ($pdo) {
      $this->pdo = $pdo;
    } else {
      echo 'Не удалось установить соединение с серверм БД';
    }
  }

  /**
   * selectAll($limit, $offset)
   *
   * метод возврвщает все записи таблицы (страницы - pages)
   * в многомерный массив
   *
   * @param int $limit количество выбираемых записей (если не указано, то выбираются все записи)
   * @param int $offset смещение первой выбираемой записи (если не указано, то записи выбираются с нулевой)
   *
   * @return Array двумерный массив выбранных записей
   */
  public function selectAll($limit = 0, $offset = 0) {
    $q_res = $this->pdo->query('SELECT * FROM ' . $this->table . (($limit == 0) ? '' : ' LIMIT ' . $offset . ', ' . $limit));
    return $q_res->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * auth($login, $password)
   *
   * проверка подлинности (аутентификация) пользователя
   *
   * @param string $login имя пользователя
   * @param string $password пароль пользователя (если параметр не передается, то используется пустой пароль)
   * @return boolean прошел ли аутентификацию пользователь
   */
  public function auth($login, $password = '') {
    $q_res = $this->pdo->query("SELECT * FROM `users` WHERE name='{$login}' AND pass='{$password}' LIMIT 0, 1");
    return ($q_res->rowCount() > 0) ? true : false;
  }

  /**
   * selectOne($id)
   *
   * выбор одной страницы по её ID
   *
   * @param int $id идентификатор в таблице
   * @return array ассоциативный массив атрибутов найденной страницы, либо false
   */
  public function selectOne($id) {
    $q_res = $this->pdo->query("SELECT * FROM {$this->table} WHERE id={$id} LIMIT 0, 1");
    return $q_res->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * updatePages($page)
   *
   * обновление записи страницы
   *
   * @param array $page одномерный ассоциативный массив с новыми данными о странице
   * (наличие элемена с ключем id - обязательно для идентификации редактируемой записи)
   * @return string/boolean если не было ошибок при обновлении записи странице,
   * то возвращается false, иначе возвращается текст ошибки
   */
  public function updatePages($page) {
    if (!isset($page['id']))
      return 'невозможно идентифицировать редактируемую запись';
    $first_field = "";
    if (isset($page['url'])) {
      $url = "url = '{$page['url']}'";
      $first_field = ", ";
    } else {
      $url = '';
    }
    if (isset($page['name'])) {
      $name = $first_field . "name = '{$page['name']}'";
      $first_field = ", ";
    } else {
      $name = "";
    }
    if (isset($page['content'])) {
      $content = $first_field . "content = '{$page['content']}'";
      $first_field = ", ";
    } else {
      $content = "";
    }
    if (isset($page['menuid'])) {
      $menuid = $first_field . "menuid = '{$page['menuid']}'";
      $first_field = ", ";
    } else {
      $menuid = "";
    }
    if ($first_field == "")
      return 'нет данных для обновления записи';
    $queryUpdate = "UPDATE {$this->table} SET {$url} {$name} {$content} {$menuid} WHERE id={$page['id']}";
    return ($this->pdo->query($queryUpdate)) ? false : 'не удалось обновить запись';
  }

  /**
   * insertPages($page)
   *
   * добавление записи страницы
   *
   * @param array $page одномерный ассоциативный массив с новыми данными о странице
   * @return string/boolean если не было ошибок при обновлении записи странице,
   * то возвращается false, иначе возвращается текст ошибки
   */
  public function insertPages($page) {
    if (!isset($page))
      return 'невозможно идентифицировать редактируемую запись';
    $first_field = "";
    if (isset($page['url'])) {
      $url = "'{$page['url']}'";
      $first_field = ", ";
    } else {
      $url = '';
    }
    if (isset($page['name'])) {
      $name = "'{$page['name']}'";
    } else {
      $name = "";
    }
    if (isset($page['content'])) {
      $content = "'{$page['content']}'";
    } else {
      $content = "";
    }
    if (isset($page['menuid'])) {
      $menuid = "'{$page['menuid']}'";
    } else {
      $menuid = "";
    }
    if ($first_field == "")
      return 'нет данных для обновления записи';
    $queryInsert = "INSERT INTO {$this->table} (`id`, `url`, `name`, `content`, `menuid`) VALUES (NULL, " . $url . "," . $name . "," . $content . "," . $menuid . ")";
    return ($this->pdo->query($queryInsert)) ? false : 'не удалось обновить запись';
  }

  /**
   * deletePages($id)
   *
   * удаление записи страницы
   *
   * @param int $id (ключ id - обязательно для идентификации редактируемой записи)
   * @return string/boolean если не было ошибок при обновлении записи страницы,
   * то возвращается false, иначе возвращается текст ошибки
   */
  public function deletePages($id) {
    if (!isset($id))
      return 'невозможно идентифицировать редактируемую запись';
    $queryDelete = "DELETE FROM {$this->table} WHERE id=$id";
    return ($this->pdo->query($queryDelete)) ? false : 'не удалось обновить запись';
  }

}
