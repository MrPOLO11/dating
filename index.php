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

//Define a personal route
$f3->route('GET|POST /personal', function($f3) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Validate all
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];

        //Optional
        $gender = $_POST['gender'];
        $premium = $_POST['premium'];

        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('age', $age);
        $f3->set('phone', $phone);
        $f3->set('gender', $gender);
        $f3->set('premium', $premium);

        if($GLOBALS['controller']->validPersonalInformation()) {
            if($premium === "checked") {
                $_SESSION['member'] = new PremiumMember($fname, $lname, $age, $gender, $phone);
                $_SESSION['premium'] = "isPremium";
            } else {
                $_SESSION['member'] = new Member($fname, $lname, $age, $gender, $phone);
            }
            /*
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['age'] = $age;
            $_SESSION['phone'] = $phone;
            $_SESSION['gender'] = $gender;
            */
            $f3->reroute('/profile');
        }
    }
    $GLOBALS['controller']->personalInfo();
});

//Define a profile route
$f3->route('GET|POST /profile', function($f3) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Must Validate
        $email = $_POST['email'];

        //Optional
        $seek = $_POST['seek'];
        $state = $_POST['state'];
        $bio = $_POST['bio'];

        $f3->set('email', $email);
        $f3->set('seek', $seek);
        $f3->set('state', $state);
        $f3->set('bio', $bio);

        var_dump($_POST);

        if($GLOBALS['controller']->validProfile()) {
            $_SESSION['member']->setEmail($email);
            $_SESSION['member']->setSeeking($seek);
            $_SESSION['member']->setState($state);
            $_SESSION['member']->setBio($bio);
            /*
            $_SESSION['email'] = $email;
            $_SESSION['seek'] = $seek;
            $_SESSION['state'] = $state;
            $_SESSION['bio'] = $bio;
            */
            if($_SESSION['premium'] === "isPremium") {
                $f3->reroute('/interests');
            }
            $f3->reroute('/summary');
        }
    }
    $GLOBALS['controller']->profile();
});

//Define a personal route
$f3->route('GET|POST /interests', function($f3) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $selectIndoorInterests = $_POST['indoorInterests'];
        $selectOutdoorInterests = $_POST['outdoorInterests'];

        $f3->set('selectIndoorInterests', $selectIndoorInterests);
        $f3->set('selectOutdoorInterests', $selectOutdoorInterests);

        if($GLOBALS['controller']->validActivities()) {
            $_SESSION['member']->setInDoorInterests($_POST['indoorInterests']);
            $_SESSION['member']->setOutDoorInterests($_POST['outdoorInterests']);
            $f3->reroute('/summary');
        }
    }
    $GLOBALS['controller']->interests();
});

//Define a personal route
$f3->route('GET /summary', function() {
    $GLOBALS['controller']->summary();
});

$f3->run();