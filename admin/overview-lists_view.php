<link href="<?php echo PS_URL; ?>assets/css/style.css" type="text/css" rel="stylesheet" />

<h2>Overview of your lists</h2>

<a href="<?php.get_bloginfo('url')?>/wp-admin/admin.php?page=admin/manage-list_controller.php">Add a list</a>

<table class="wp-list-table widefat fixed" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" id="id" class="manage-column" style="">ID</th>
            <th scope="col" id="name" class="manage-column" >Name</th>
            <th scope="col" id="page" class="manage-column" >Page</th>
        </tr>
    </thead>
    <tfoot>

    </tfoot>
    <tbody>
        <?php
        foreach ($lists as $list) {
            $page = '';
            if($list->page_id != null && $list->page_id != 0)
                $page = ps_getPageTitleById($list->page_id);
            else
                $page = '<span class="ok">DEFAULT</span>';
            
            echo '<tr><td>' . $list->id . '</td><td><a href="'.get_bloginfo('url').'/wp-admin/admin.php?page=admin/manage-list_controller.php&list_id='.$list->id.'">' . $list->name . '</a></td><td>' . $page . '</td></tr>';
        }
        ?>

    </tbody>
</table>