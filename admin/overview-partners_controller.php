<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
} else {
    $partners = ps_getAllPartners();

    require ('overview-partners_view.php');
}
?>
