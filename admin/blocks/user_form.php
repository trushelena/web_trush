<?php
if ((isset($_GET['action'])) & ($_GET['action'] == 'edit') & (isset($_GET['user_id']))) {
  $act = 'edit';
  $user = $usersObj->selectOne($_GET['user_id']);
}
?>
<div class="obj_form">
  <form action="?obj=users&action=<?php echo ($act == 'edit') ? 'update' : 'insert'; ?>" method="post" enctype="multipart/form-data">
    <?php if ($act == 'edit') { ?>
      <input type="hidden" name="id" value="<?php echo $user['id']; ?>"/>
    <?php } ?>
    <div>
      Имя (login): <input type="text" name="name" value="<?php echo @$user['name']; ?>" />
    </div>
    <div>
      Пароль: <input type="password" name="pass" value="<?php echo @$user['pass']; ?>" />
    </div>
    <div class="btns">
      <input type="submit" value="Сохранить" />
    </div>
  </form>
</div>