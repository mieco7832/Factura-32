<?php

include_once 'class/controller/Redirect.php';

$View = new Redirect();

if (!isset($_REQUEST['c'])) {
    $View->index();
} else{
    
}
?>
   