<?php
require_once ('helpers.php');
require_once ('functions.php');
require_once ('init.php');

//    $detail_lot = include_template('lot.php' ,[
//        'lots' => lot_list($con)
//    ]);

if (!isset($_GET['id'])) {
    print(file_get_contents("pages/404.html"));
    return;
}

$lot = lot_detail($con, $_GET['id']);

if (!$lot) {
    print(file_get_contents("pages/404.html"));
    return;
}


$detail_lot = print(include_template('lot.php', [
    'lots' => $lot]));
