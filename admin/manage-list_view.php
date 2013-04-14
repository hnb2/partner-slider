<link href="<?php echo PS_URL; ?>assets/css/style.css" type="text/css" rel="stylesheet" />
<script src="<?php echo PS_URL; ?>assets/js/manage-list.js" type="text/javascript"></script>

<?php if ($_GET['list_add_error'] == 'error') echo "<h3 class='error'>Unable to add this list, please check your inputs.</h3>" ?>
<?php if ($_GET['list_id_error'] == 'error') echo "<h3 class='error'>Unable to update this list, it was not found in the database.</h3>" ?>
<?php if ($_GET['list_update_error'] == 'error') echo "<h3 class='error'>Unable to update this list, please check your inputs.</h3>" ?>

<form action="<?php echo PS_URL; ?>admin/manage-list_controller.php" method="POST" id="manage-list"> 
    <p><label for="list_name">Name</label>
        <input type="text" id="list_name" name="list_name" value="<?php if ($list != null) echo $list->name; ?>"/>
        <?php if ($_GET['list_name_error'] == 'error') echo "<span class='error'>Please enter a valid name</span>" ?></p>

    <p><label for="pages">Page (optional)</label>
        <select id="pages" name="pages">
            <option value="-1">Default</option>
            <?php
            foreach ($pages as $page) {
                if ($list != null && $list->page_id == $page->ID)
                    echo '<option value="' . $page->ID . '" selected="selected">' . $page->post_name . '</option>';
                else
                    echo '<option value="' . $page->ID . '">' . $page->post_name . '</option>';
            }
            ?>
        </select></p>

    <input type="hidden" id="list_id" name="list_id" value="<?php if ($list != null) echo $list->id; ?>"/>

    <input type="submit" id="submit_manage-list" value="<?php if ($list == null) echo "Add";else echo "Update"; ?>"/>

</form>

<p><a href="<?php echo bloginfo('url'); ?>/wp-admin/admin.php?page=admin/overview-lists_controller.php">Back to the lists</a></p>

<hr />

<?php if ($partners != null) : ?>

    <input type="button" id="save-partner-list" name="save-partner-list" value="Save my partners for this list"/>
    <img src="<?php echo PS_URL; ?>assets/images/ajax-loader.gif" title="loading" alt="loading" id="loading-image" style="display: none;"/>
    <p id="results" ></p>

    <input type="hidden" id="url" name="url" value="<?php echo PS_URL; ?>"/>

    <table class="all-partners">
        <tr>
            <?php
            foreach ($partners as $partner) {
                if (ps_contains($partner->id, $partners_ids))
                    echo '<td class="in-use"';
                else
                    echo '<td';
                echo ' id="' . $partner->id . '">' . $partner->name . '</td>';

                $index++;

                if ($index == 5) {
                    echo '</tr><tr>';
                    $index = 0;
                }
            }
            ?>
        </tr>
    </table>

    <hr />

<?php endif; ?>


