<link href="<?php echo PS_URL; ?>assets/css/style.css" type="text/css" rel="stylesheet" />

<?php if($_GET['partner_add_error']=='error') echo "<h3 class='error'>Unable to add this partner, please check your inputs.</h3>" ?>
<?php if($_GET['partner_id_error']=='error') echo "<h3 class='error'>Unable to update this partner, it was not found in the database.</h3>" ?>
<?php if($_GET['partner_update_error']=='error') echo "<h3 class='error'>Unable to update this partner, please check your inputs.</h3>" ?>

<form action="<?php echo PS_URL; ?>admin/manage-partner_controller.php" method="POST" id="manage-partner" enctype="multipart/form-data"> 
    
    <p><label for="partner_name">Name</label>
    <input type="text" id="partner_name" name="partner_name" value="<?php if($partner != null) echo $partner->name; ?>"/>
    <?php if($_GET['partner_name_error']=='error') echo "<span class='error'>Please enter a valid name</span>" ?></p>
    
    <p><label for="partner_description">Description</label>
    <input type="text" id="partner_description" name="partner_description" value="<?php if($partner != null) echo stripslashes($partner->description); ?>"/>
    <?php if($_GET['partner_description_error']=='error') echo "<span class='error'>Please enter a valid description</span>" ?></p>
    
    <p><label for="partner_url">URL</label>
    <input type="text" id="partner_url" name="partner_url" value="<?php if($partner != null) echo $partner->url; ?>"/>
    <?php if($_GET['partner_url_error']=='error') echo "<span class='error'>Please enter a valid URL</span>" ?></p>
    
    <p><label for="partner_icon">Icon</label>
    <input type="file" id="partner_icon" name="partner_icon" size="34" value=""/>
    <?php if($_GET['partner_icon_error']=='error') echo "<span class='error'>Please enter a valid icon</span>" ?></p>
    
    <input type="hidden" id="partner_id" name="partner_id" value="<?php if($partner != null) echo $partner->id; ?>"/>
    
    <input type="submit" name="submit_manage-partner" value="<?php if($partner == null) echo "Add"; else echo "Update";  ?>">
    
</form>

    <p><a href="<?php echo bloginfo('url'); ?>/wp-admin/admin.php?page=admin/overview-partners_controller.php">Back to the partners</a></p>

<hr />