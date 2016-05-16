<ul>
    <?php
    $menu_result = $pdo->query("SELECT * FROM  `pages`");
    while ($menu_item = $menu_result->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <li><a href="<?php echo $menu_item["url"] ?>" id="<?php echo $menu_item["menuid"] ?>"><?php echo $menu_item["name"] ?></a></li>
        <?php
    }
    ?>
</ul>