<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    include('../includes/functions.php');
    
    //Get the POST parameters
    $thumb_width = intval($_POST['thumb_width']);
    $thumb_height = intval($_POST['thumb_height']);
    
    //Create an array to hold the errors
    $errors = array();
    
    //Test the thumbnail height
    if($thumb_height <= 0 || $thumb_height > 200)
        $errors[] = 'thumb_height_error=error';
    else 
        update_option('ps_thumb_height', $thumb_height);

    //Test the thumbnail width
    if($thumb_width <= 0 || $thumb_width > 200)
        $errors[] = 'thumb_width_error=error';
    else
        update_option('ps_thumb_width', $thumb_width);
    
    //If errors were found
    if(count($errors) > 0){
        
        //Transform the array in a string separated by &
        $errors_str = "";
        foreach ($errors as $error) {
            $errors_str .= $error . '&';
        }
        
        //Redirection with the errors
        Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/about_controller.php&' . $errors_str);
    }
    else{
        //Redirection
        Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/about_controller.php');        
    }
}
else{
    $thumb_width = get_option('ps_thumb_width');
    $thumb_height = get_option('ps_thumb_height');
    
    require ('about_view.php');
}
?>
