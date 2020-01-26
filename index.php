<?php
/**
 * Marcos Rivera
 * 01-15-2020
 * 328/dating/index.php
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once ("vendor/autoload.php");

//Instantiate Fat-Free framework (F3)
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a personal route
$f3->route('POST /personal', function() {
    $view = new Template();
    echo $view->render('views/personal-information.html');
});

$f3->run();