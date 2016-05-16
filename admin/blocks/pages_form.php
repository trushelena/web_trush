<?php
if ((isset($_GET['action'])) & ($_GET['action'] == 'edit') & (isset($_GET['page_id']))) {
  $act = 'edit';
  $page = $pagesObj->selectOne($_GET['page_id']);
}
?>
<div class="obj_form">
  <form action="?obj=pages&action=<?php echo ($act == 'edit') ? 'update' : 'insert'; ?>" method="post"
        enctype="multipart/form-data">        
          <?php if ($act == 'edit') { ?>
      <input type="hidden" name="id" value="<?php echo $page['id']; ?>"/>
    <?php } ?>
    <div>
      <div>
        URL:
      </div>
      <div>
        <input type="text" name="url" value="<?php echo @$page['url']; ?>"/>
      </div>
    </div>
    <div>
      <div>
        Заголовок меню:
      </div>
      <div>
        <input type="text" name="name" value="<?php echo @$page['name']; ?>"/>
      </div>
    </div>
    <div>
      <div>
        Содержимое:
      </div>
      <div>
        <textarea name="content"><?php echo @$page['content']; ?></textarea>
      </div>
    </div>
    <div>
      <div>
        Идентификатор меню:
      </div>
      <div>
        <input type="text" name="menuid" value="<?php echo @$page['menuid']; ?>"/>
      </div>
    </div>
    <div class="btns">
      <input type="submit" value="Сохранить"/>
    </div>
  </form>
</div>