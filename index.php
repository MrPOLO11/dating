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
require_once ('vendor/autoload.php');
require_once ('model/validate.php');

//Instantiate Fat-Free framework (F3)
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define arrays

//Define a default route
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a personal route
$f3->route('GET|POST /personal', function($f3) {
    $view = new Template();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];

        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('age', $age);
        $f3->set('phone', $phone);

        if(validPersonalInformation()) {
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['age'] = $age;
            $_SESSION['phone'] = $phone;
            $f3->reroute('/profile');
        }
    }
    echo $view->render('views/personal-information.html');
});

//Define a profile route
$f3->route('GET|POST /profile', function() {
    /*$_SESSION['fname'] = $_POST['fname'];
    $_SESSION['lname'] = $_POST['lname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['telephone'] = $_POST['telephone'];*/
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