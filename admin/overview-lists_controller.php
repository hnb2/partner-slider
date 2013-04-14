<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
}
else{
    $lists = ps_getAllLists();
    
    require ('overview-lists_view.php');
}
?>
