<?php

/**
 * Класс userClass
 * предназначен для работы с таблицей пользователей (users)
 *
 * @author Труш Е.Н.
 */
class userClass {

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
  private $table = 'users';

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
   * метод возврвщает все записи таблицы (пользователи - users)
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
    $q_res = $this->pdo->query("SELECT * FROM {$this->table} WHERE name='{$login}' AND pass='{$password}' LIMIT 0, 1");
    return ($q_res->rowCount() > 0) ? true : false;
  }

  /**
   * selectOne($id)
   * 
   * выбор одного пользователя по его ID
   * 
   * @param int $id идентификатор пользователя в таблице
   * @return array ассоциативный массив атрибутов найденного пользователя, либо false
   */
  public function selectOne($id) {
    $q_res = $this->pdo->query("SELECT * FROM {$this->table} WHERE id={$id} LIMIT 0, 1");
    return $q_res->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * updateUser($user)
   * 
   * обновление записи пользователя
   * 
   * @param array $user одномерный ассоциативный массив с новыми данными о пользователе 
   * (наличие элемена с ключем id - обязательно для идентификации редактируемой записи)
   * @return string/boolean если не было ошибок при обновлении записи пользователя, 
   * то возвращается false, иначе возвращается текст ошибки
   */
  public function updateUser($user) {
    if (!isset($user['id']))
      return 'невозможно идентифицировать редактируемую запись';
    $first_field = "";
    if (isset($user['name'])) {
      $name = "name = '{$user['name']}'";
      $first_field = ", ";
    } else {
      $name = '';
    }
    if (isset($user['pass'])) {
      $pass = $first_field . "pass = '{$user['pass']}'";
      $first_field = ", ";
    } else {
      $pass = "";
    }
    if ($first_field == "")
      return 'нет данных для обновления записи';
    $queryUpdate = "UPDATE {$this->table} SET {$name} {$pass}  WHERE id={$user['id']}";
    return ($this->pdo->query($queryUpdate)) ? false : 'не удалось обновить запись';
  }

  /**
   * insertUser($user)
   *
   * добавление записи пользователя
   *
   * @param array $user одномерный ассоциативный массив с новыми данными о пользователе
   * @return string/boolean если не было ошибок при обновлении записи пользователя,
   * то возвращается false, иначе возвращается текст ошибки
   */
  public function insertUser($user) {
    if (!isset($user))
      return 'невозможно идентифицировать редактируемую запись';
    $first_field = "";
    if (isset($user['name'])) {
      $login = "'{$user['name']}'";
      $first_field = ", ";
    } else {
      $login = '';
    }
    if (isset($user['pass'])) {
      $password = "'{$user['pass']}'";
    } else {
      $password = "";
    }
    if ($first_field == "")
      return 'нет данных для обновления записи';
    $queryInsert = "INSERT INTO {$this->table} (`id`, `name`, `pass`) VALUES (NULL, " . $login . "," . $password . ")";
    return ($this->pdo->query($queryInsert)) ? false : 'не удалось обновить запись';
  }

  /**
   * deleteUser($id)
   *
   * удаление записи пользователя
   *
   * @param int $id (ключ id - обязательно для идентификации редактируемой записи)
   * @return string/boolean если не было ошибок при обновлении записи пользователя,
   * то возвращается false, иначе возвращается текст ошибки
   */
  public function deleteUser($id) {
    if (!isset($id))
      return 'невозможно идентифицировать редактируемую запись';
    $queryDelete = "DELETE FROM {$this->table} WHERE id=$id";
    return ($this->pdo->query($queryDelete)) ? false : 'не удалось обновить запись';
  }
}
