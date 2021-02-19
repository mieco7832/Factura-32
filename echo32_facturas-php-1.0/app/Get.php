<?php

include_once '../class/config/Conector.php';
include_once '../class/controller/Items.php';
include_once '../class/controller/Historial.php';

$Controller = new Items();
$Historial = new Historial();

if (isset($_GET['newItem'])) {
    $Controller->newItem();
}

if (isset($_GET['create'])) {
    $Controller->create();
}

if (isset($_GET['getData'])) {
    $Controller->getData();
}

if (isset($_GET['info'])) {
    $Controller->getInfo();
}

if (isset($_GET['img'])) {
    $Controller->getFile();
}

if (isset($_GET['setInfo'])) {
    $Controller->setInfo();
}

if (isset($_GET['history'])) {
    $Historial->getFacturas();
}
?>

