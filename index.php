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
    $_SESSION['fname'] = $_POST['fname'];
    $_SESSION['lname'] = $_POST['lname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['telephone'] = $_POST['telephone'];
    $view = new Template();
    echo $view->render('views/profile.html');
});

//Define a personal route
$f3->route('POST /interests', function() {
    $_SESSION['bio'] = $_POST['bio'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seek'] = $_POST['seek'];
    $view = new Template();
    echo $view->render('views/interests.html');
});

//Define a personal route
$f3->route('POST /summary', function() {
    $_SESSION['interest'] = "";
    if(!empty($_POST['interest'])) {
        $_SESSION['choices'] = $_POST['interest'];
        foreach ($_SESSION['choices'] AS $choice) {
            $_SESSION['interest'] = $_SESSION['interest']." $choice";
        }
    }
    $view = new Template();
    echo $view->render('views/profile-summary.html');
});

$f3->run();