<?php
/**
 * Marcos Rivera
 * 01-15-2020
 * 328/dating/index.php
 */

session_start();

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

//Define a profile route
$f3->route('POST /profile', function() {
    var_dump($_POST);
    $view = new Template();
    echo $view->render('views/profile.html');
});

//Define a personal route
$f3->route('POST /interests', function() {
    var_dump($_POST);
    $view = new Template();
    echo $view->render('views/interests.html');
});

//Define a personal route
$f3->route('POST /summary', function() {
    var_dump($_POST);
    $view = new Template();
    echo $view->render('views/profile-summary.html');
});

$f3->run();