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
$f3->set('genders', array('Male', 'Female'));
$f3->set('indoorActs', array('tv', 'movie', 'cooking', 'boardgames', 'puzzles', 'reading', 'playing cards', 'video games'));
$f3->set('outdoorActs', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));
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
    $view = new Template();
    echo $view->render('views/home.html');
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

        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('age', $age);
        $f3->set('phone', $phone);
        $f3->set('gender', $gender);

        if(validPersonalInformation()) {
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['age'] = $age;
            $_SESSION['phone'] = $phone;
            $_SESSION['gender'] = $gender;
            $f3->reroute('/profile');
        }
    }
    $view = new Template();
    echo $view->render('views/personal-information.html');
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

        if(validProfile()) {
            $_SESSION['email'] = $email;
            $_SESSION['seek'] = $seek;
            $_SESSION['state'] = $state;
            $_SESSION['bio'] = $bio;
            $f3->reroute('/interests');
        }
    }
    $view = new Template();
    echo $view->render('views/profile.html');
});

//Define a personal route
$f3->route('GET|POST /interests', function() {
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