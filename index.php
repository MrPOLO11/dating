<?php
/**
 * Marcos Rivera
 * 01-15-2020
 * 328/chicken/index.php
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once ("vendor/autoload.php");

//Instantiate Fat-Free framework (F3)
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {
    echo"Hello, World";
});

$f3->run();