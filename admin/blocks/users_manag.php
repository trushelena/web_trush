<?php
if ((isset($_GET['obj'])) & ($_GET['obj'] == 'users')) {
  $usersObj = new userClass($pdo); // создание объекта "пользователи"
  ?>
  <h2>Управление пользователями</h2>
  <?php
  if (isset($_GET['action'])) {
    switch ($_GET['action']) {
      case 'edit':
        require_once 'blocks/user_form.php';
        break;
      case 'new':
        require_once 'blocks/user_form.php';
        break;
      case 'insert':
        if (isset($_POST)) {
          echo $usersObj->insertUser($_POST); // см. комментарии в классе (в netbeans можно подвести курсор мыши и удерживать Ctrl)
        }
      case 'update':
        if (isset($_POST['id'])) {
          echo $usersObj->updateUser($_POST); // см. комментарии в классе (в netbeans можно подвести курсор мыши и удерживать Ctrl)
        }
        break;
      case 'delete':
        if (isset($_GET['user_id'])) {
          echo $usersObj->deleteUser($_GET['user_id']);
        }
        break;
      default:
        break;
    }
  }
  ?>
  <table id="users_manag_tab" class="manag_tab">
    <caption>
      <a href="?obj=users&action=new">
        Новый пользователь
      </a>
    </caption>
    <tr>
      <th class="buts" colspan="2">Действия</th>
      <th class="id">ID</th>
      <th class="user_name">Имя (login) пользователя</th>
      <th class="user_pass">Пароль</th>
    </tr>
    <?php
    $users = $usersObj->selectAll(); // см. комментарии в классе (в netbeans можно подвести курсор мыши и удерживать Ctrl)
    foreach ($users as $user) { // вывод всех записей пользователей в таблице с действиями
      ?>
      <tr>
        <td class="but_edit">
          <a href="?obj=users&action=edit&user_id=<?php echo $user['id']; ?>">
            Редактирование
          </a>
        </td>
        <td class="but_delete">
          <a href="?obj=users&action=delete&user_id=<?php echo $user['id']; ?>">
            Удаление
          </a>
        </td>
        <td class="id"><?php echo $user['id']; ?></td>
        <td class="user_name"><?php echo $user['name']; ?></td>
        <td class="user_pass"><?php echo $user['pass']; ?></td>
      </tr>
    <?php } ?>
  </table>
<?php } ?>