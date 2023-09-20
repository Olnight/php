<?php
require_once ('helpers.php');
require_once ('init.php');
require_once ('functions.php');
$lots = getNewLots($con);
$categories = getCategories($con);
$main = include_template('main.php', [
    'lots'=> $lots,
    'categories'=> $categories,
]);
$layout = include_template('layout.php', [
    'main'=> $main,
    'is_auth'=> $is_auth,
    'user_name'=> $user_name,
    'title'=> 'Главная',
    'categories'=> $categories,
]);
print($layout);