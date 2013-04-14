<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    include('../includes/functions.php');
    
    //Get all the POST parameters
    $list_id = $_POST['list_id'];
    $list_name = isset($_POST['list_name'])?trim($_POST['list_name']):'';
    $pages = intval($_POST['pages']);
    
    //Testing the name parameter
    if(!preg_match("/^[a-zA-Z0-9_ ]{3,20}$/", $list_name)){
        Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-list_controller.php&list_name_error=error&list_id='.$list_id);
        exit;
    }
    
    //Testing the page parameter (optionnal, -1 = none)
    $page = null;
    if ($pages > 0)
        $page = ps_getPageTitleById($pages);

    if ($page == null)
        $pages = 0;

    //Test if the list_id parameter has been set and is correct
    if (isset($_POST['list_id']) && intval($list_id) > 0) {
        $list_id = intval($list_id);
        $list = ps_getListById($list_id);

        if ($list == null) {
            Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-list_controller.php&list_id_error=error');
        } else {
            //Update the list
            $res = ps_updateList($list_id, $list_name, $pages);

            if(!res)
                Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-list_controller.php&list_update_error=error');               
            else
                Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-list_controller.php&list_id=' . $list_id);
        }
    } else {
        //Create a list
        $res = ps_addList($list_name, $pages);
        $res = trim($res);

        if (!$res)
            Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-list_controller.php&list_add_error=error');
        else
            Header('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=admin/manage-list_controller.php&list_id=' . $res);
    }
}
else {
    //Get the list of all the pages of the website
    $pages = get_pages(array(
            'sort_order' => 'ASC',
            'sort_column' => 'post_title'
            ));

    //Get the list id as a GET parameter
    $list_id = $_GET['list_id'];
    $list = null;

    //Get the list by its id
    if (intval($list_id) > 0)
        $list = ps_getListById($list_id);
    
    //If the list exists, we retrieve all the partners
    $partners = null;
    $partners_ids = null;
    $index = 0;
    if($list != null){
        $partners = ps_getAllPartners();
        $partners_ids = ps_getPartnersIdsByListId($list_id);
    }

    //if there is a list as a parameter, we can edit it
    if ($list != null)
        echo '<h2>Manage your list : ' . $list->name . '</h2>';
    else //Else we add it
        echo '<h2>Add a new list</h2>';
    
    require ('manage-list_view.php');
}
?>