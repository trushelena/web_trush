<?php
if ((isset($_GET['obj'])) & ($_GET['obj'] == 'pages')) {
    $pagesObj = new pagesClass($pdo); // создание объекта "страница"
    ?>
    <h2>Управление страницами</h2>
    <?php
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'edit':
                require_once 'blocks/pages_form.php';
                break;
            case 'new':
                require_once 'blocks/pages_form.php';
                break;
            case 'insert':
                if (isset($_POST)) {
                    echo $pagesObj->insertPages($_POST); // см. комментарии в классе (в netbeans можно подвести курсор мыши и удерживать Ctrl)
                }
            case 'update':
                if (isset($_POST['id'])) {
                    echo $pagesObj->updatePages($_POST); // см. комментарии в классе (в netbeans можно подвести курсор мыши и удерживать Ctrl)
                }
                break;
            case 'delete':
                if (isset($_GET['page_id'])) {
                    echo $pagesObj->deletePages($_GET['page_id']);
                }
                break;

            default:
                break;
        }
    }
    ?>
    <table id="users_manag_tab" class="manag_tab">
        <caption>
            <a href="?obj=pages&action=new">
                Новая страница
            </a>
        </caption>
        <tr>
            <th class="buts" colspan="2">Действия</th>
            <th class="id">ID</th>
            <th class="user_name">URL</th>
            <th class="user_pass">Заголовок меню</th>
            <th class="menu_id">Идентификатор меню</th>
        </tr>
        <?php
        $pages = $pagesObj->selectAll(); // см. комментарии в классе (в netbeans можно подвести курсор мыши и удерживать Ctrl)
        foreach ($pages as $page) { // вывод всех записей пользователей в таблице с действиями
            ?>
            <tr>
                <td class="but_edit">
                    <a href="?obj=pages&action=edit&page_id=<?php echo $page['id']; ?>">
                        Редактирование
                    </a>
                </td>
                <td class="but_delete">
                    <a href="?obj=pages&action=delete&page_id=<?php echo $page['id']; ?>">
                        Удаление
                    </a>
                </td>
                <td class="id"><?php echo $page['id']; ?></td>
                <td class="user_name"><?php echo $page['url']; ?></td>
                <td class="user_pass"><?php echo $page['name']; ?></td>
                <td class="menu_id"><?php echo $page['menuid']; ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>