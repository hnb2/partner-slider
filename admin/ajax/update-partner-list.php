<?php

    //Includes the utility functions
    include_once('../../includes/functions.php');
    
    //Get the array of partners
    $partners = $_POST['partners'];
    
    //Get the list id
    $list_id = intval($_POST['list_id']);
    
    //Test the array
    if(!is_array($partners)){
        echo 'The parameter "partners" is not a valid array.';
        exit;
    }
    else{
        foreach($partners as $partner){
            if(intval($partner) <= 0){
                echo 'At least one of the value in the array "partners" is not valid.';
                exit;
            }
        }
    }
    
    //Test the list ID
    if($list_id <= 0){
        echo 'The parameter "list_id" is not a valid value.';
        exit;
    }
    else{
        $list = ps_getListById($list_id);
        if($list == null){
            echo 'The list could not be find with the ID you provided.';
            exit;
        }
    }
        
    //Update the list
    ps_updatePartnerList($list_id, $partners);
    
    echo 'DONE';

?>
