<link href="<?php echo PS_URL; ?>assets/css/style.css" type="text/css" rel="stylesheet" />

<h2>Overview of your partners</h2>

<a href="<?php echo bloginfo('url'); ?>/wp-admin/admin.php?page=admin/manage-partner_controller.php">Add a Partner</a>

<table class="wp-list-table widefat fixed" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" id="icon" class="manage-column" style="">Icon</th>
            <th scope="col" id="name" class="manage-column" >Name</th>
            <th scope="col" id="url" class="manage-column" >URL</th>
            <th scope="col" id="description" class="manage-column" >Description</th>
        </tr>
    </thead>
    <tfoot>

    </tfoot>
    <tbody>
        <?php
        foreach ($partners as $partner) {
            $html = '<tr><td><img src="' . PS_URL . 'assets/images/partners/thumbs/' . $partner->icon . '" alt="' . $partner->name . '" title="' . $partner->name . '" /></td>';
            $html .= '<td><a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-partner_controller.php&partner_id=' . $partner->id . '">' . $partner->name . '</a></td>';
            $html .= '<td><a href="' . $partner->url . '">' . $partner->url . '</a></td>';
            $html .= '<td>' . stripslashes($partner->description) . '</td></tr>';

            echo $html;
        }
        ?>

    </tbody>
</table>