<link href="<?php echo PS_URL; ?>assets/css/style.css" type="text/css" rel="stylesheet" />
<script src="<?php echo PS_URL; ?>assets/js/resize-images.js" type="text/javascript"></script>

<h2>About Partner Slider</h2>

<p>There are 2 menus :</p>
<ul>
    <li>Partners : offers you the possibility to add partners (name, icon, URL, description, ...), edit, delete and list them.</li>
    <li>Lists : a list is a set of partners, you can create multiple lists with different partners and decide to display them on particular pages. If you do not set a page to a list, it will be the "default" list which will appear on all the other pages.</li>
</ul>

<hr />

<h2>Settings</h2>

<form action="<?php echo PS_URL; ?>admin/about_controller.php" method="POST" id="about">
    <p><label for="thumb_width">Thumbnail Width</label>
    <input type="text" id="thumb_width" name="thumb_width" value="<?php echo $thumb_width; ?>"/>
    <?php if($_GET['thumb_width_error']=='error') echo "<span class='error'>Please enter a valid width (1 to 199, unit used is pixel)</span>" ?></p>

    <p><label for="thumb_height">Thumbnail Height</label>
    <input type="text" id="thumb_height" name="thumb_height" value="<?php echo $thumb_height; ?>"/>
    <?php if($_GET['thumb_height_error']=='error') echo "<span class='error'>Please enter a valid height (1 to 199, unit used is pixel)</span>" ?></p>

    <input type="submit" id="submit_about" value="Save settings"/>
</form>

<input type="button" id="resize-images" name="resize-images" value="Resize all my thumbnails"/>
<img src="<?php echo PS_URL; ?>assets/images/ajax-loader.gif" title="loading" alt="loading" id="loading-image" style="display: none;"/>
<p id="results" ></p>

<input type="hidden" id="url" name="url" value="<?php echo PS_URL; ?>"/>

<hr />