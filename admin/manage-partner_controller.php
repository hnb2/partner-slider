<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include('../includes/functions.php');
    require_once('../includes/ImageManipulator.php');

    //Get all the parameters
    $name = isset($_POST['partner_name']) ? $_POST['partner_name'] : '';
    $description = isset($_POST['partner_description']) ? $_POST['partner_description'] : '';
    $url = isset($_POST['partner_url']) ? $_POST['partner_url'] : '';
    $icon = ($_FILES["partner_icon"]["error"] == 0) ? $_POST['partner_icon'] : '';
    $partner_id = $_POST['partner_id'];

    //Will contain the parameters which have errors
    $errors = array();

    //Testing the name
    if (!preg_match("/^[a-zA-Z0-9éèàêç ]{3,40}$/", $name)) {
        $errors[] = "partner_name_error=error";
    }

    //Testing the description
    if (!empty($description)) {
        if (!preg_match("/^[a-zA-Z0-9éèàêç,\'. ]{1,150}$/", stripslashes($description))) {
            $errors[] = "partner_description_error=error";
        }
    }

    //Testing the URL
    if (!preg_match("/^((http:\/\/|https:\/\/)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(\/([a-zA-Z-_\/\.0-9#:?=&;%,]*)?)?)$/", $url)) {
        $errors[] = "partner_url_error=error";
    }

    //Testing the icon
    if ((intval($_POST['partner_id']) <= 0) || ( intval($_POST['partner_id']) > 0 && !empty($_FILES["partner_icon"]["name"]) ) ) {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES["partner_icon"]["name"]));
        if ((($_FILES["partner_icon"]["type"] == "image/gif") || ($_FILES["partner_icon"]["type"] == "image/jpeg") || ($_FILES["partner_icon"]["type"] == "image/png") || ($_FILES["partner_icon"]["type"] == "image/pjpeg")) && (intval($_FILES["partner_icon"]["size"]) < 1000000) && in_array($extension, $allowedExts)) {
            $icon = $_FILES["partner_icon"]["name"];
        } else {
            $errors[] = "partner_icon_error=error&name=" . $_FILES["partner_icon"]["name"] . "&type=" . $_FILES["partner_icon"]["type"] . "&size=" . $_FILES["partner_icon"]["size"] . "&extension=" . $extension;
        }
    } else {
        $icon = -1;
    }

    //If there are errors, we sent back the page which will display them
    if (count($errors) > 0) {

        //Transform the array in a string separated by &
        $errors_str = "";
        foreach ($errors as $error) {
            $errors_str .= $error . '&';
        }

        Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-partner_controller.php&' . $errors_str);
    } //Otherwise we add or update the partner
    else {
        //Test if the partner id is set correctly
        if (isset($_POST['partner_id']) && intval($partner_id) > 0) {
            $partner_id = intval($partner_id);
            $partner = ps_getPartnerById($partner_id);

            if ($partner == null) {
                Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-partner_controller.php&partner_id_error=error');
            } else {
                //If the icon remains the same
                if($icon == -1)
                    $icon = $partner->icon;
                
                //Update the partner
                $res = ps_updatePartner($partner_id, $name, $description, $url, $icon);

                if (!$res)
                    Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-partner_controller.php&partner_update_error=error');
                else
                    Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-partner_controller.php&partner_id=' . $partner_id);
            }
        }
        else {
            //Add the partner
            $result = ps_addPartner($name, $description, $url, $icon);

            if (!result) {
                Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-partner_controller.php&partner_add_error=error');
            } else {
                //Move the image
                move_uploaded_file($_FILES["partner_icon"]["tmp_name"], PS_DIR . "assets/images/partners/" . $_FILES["partner_icon"]["name"]);

                //Create a thumbnail
                $manipulator = new ImageManipulator(PS_DIR . "assets/images/partners/" . $_FILES["partner_icon"]["name"]);
                
                //Get the width and height from the options
                $thumb_width = get_option('ps_thumb_width');
                $thumb_height = get_option('ps_thumb_height');
                
                //Resize
                $thumb = $manipulator->resample($thumb_width, $thumb_height);
                
                //Save
                $manipulator->save(PS_DIR . "assets/images/partners/thumbs/" . $_FILES["partner_icon"]["name"]);

                //Redirect
                Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-partner_controller.php&partner_id=' . $result);
            }
        }
    }
} else {
    //Get the partner id as a GET parameter
    $partner_id = $_GET['partner_id'];
    $partner = null;

    //Get the partner by its id
    if (intval($partner_id) > 0)
        $partner = ps_getPartnerById($partner_id);

    //if there is a partner as a parameter, we can edit it
    if ($partner != null) {
        echo '<h2>Manage your partner : </h2>';
        echo '<h2><img src="' . PS_URL . 'assets/images/partners/thumbs/' . $partner->icon . '" alt="' . $partner->name . '" title="' . $partner->name . '" />' . $partner->name . '</h2>';
    } else { //Else we add it
        echo '<h2>Add a new partner</h2>';
    }

    require ('manage-partner_view.php');
}
?>