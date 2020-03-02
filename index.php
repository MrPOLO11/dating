<?php
/**
 * Marcos Rivera
 * 01-15-2020
 * 328/dating/index.php
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once ('vendor/autoload.php');
//require_once ('model/validate.php');

//Start session
session_start();

//Instantiate Fat-Free framework (F3)
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

$db = new Database();
$controller = new DatingController($f3);

//Define arrays
$f3->set('genders', array('Male', 'Female'));
$f3->set('indoorInterests', array('tv', 'movie', 'cooking', 'boardgames', 'puzzles', 'reading', 'playing cards', 'video games'));
$f3->set('outdoorInterests', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));
$f3->set('states', array('AL'=>'Alabama',
    'AK'=>'Alaska',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming'));

//Define a default route
$f3->route('GET /', function() {
    $GLOBALS['controller']->home();
});

//Define a admin route
$f3->route('GET /admin', function() {
    $GLOBALS['controller']->viewMembers();
});

//Define a personal route
$f3->route('GET|POST /personal', function($f3) {
    $GLOBALS['controller']->checkPersonal();
});

//Define a profile route
$f3->route('GET|POST /profile', function($f3) {
    $GLOBALS['controller']->checkProfile();
});

//Define a personal route
$f3->route('GET|POST /interests', function($f3) {
    $GLOBALS['controller']->checkActivities();
});

//Define a personal route
$f3->route('GET /summary', function() {
    $GLOBALS['controller']->summary();
    $_SESSION = array();
    session_destroy();
});

$f3->run();