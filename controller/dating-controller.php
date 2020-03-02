<?php

class DatingController
{
    private $_f3; //Router
    private $_val; //Validation

    public function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_val = new Model();
    }

    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function viewMembers()
    {
        $members = $GLOBALS['db']->getMembers();

        $this->_f3->set('members', $members);
        $view = new Template();
        echo $view->render('views/admin.html');
    }

    function personalInfo()
    {
        $view = new Template();
        echo $view->render('views/personal-information.html');
    }

    function profile()
    {
        $view = new Template();
        echo $view->render('views/profile.html');
    }

    function interests()
    {
        $view = new Template();
        echo $view->render('views/interests.html');
    }

    function summary()
    {
        global $f3;
        $member = new Member($f3->get('fname'), $f3->get('lname'), $f3->get('age'),
            $f3->get('gender'), $f3->get('phone'));
        $GLOBALS['db']->insertMember();
        $view = new Template();
        echo $view->render('views/profile-summary.html');
    }

    function checkPersonal()
    {
        global $f3;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            if ($GLOBALS['controller']->validPersonalInformation()) {
                if ($premium === "checked") {
                    $_SESSION['member'] = new PremiumMember($fname, $lname, $age, $gender, $phone);
                    $_SESSION['premium'] = "isPremium";
                } else {
                    $_SESSION['member'] = new Member($fname, $lname, $age, $gender, $phone);
                }
                $f3->reroute('/profile');
            }
        }
        $this->personalInfo();
    }

    function validPersonalInformation()
    {
        global $f3;
        $isValid = true;

        if (!$this->_val->validName($f3->get('fname'), $f3->get('lname'))) {
            $isValid = false;
            $f3->set("errors['fname']", "Please enter first name");
            $f3->set("errors['lname']", "Please enter last name");
        }

        if(!$this->_val->validAge($f3->get('age'))) {
            $isValid = false;
            $f3->set("errors['age']", "Please enter an age");
        }

        if(!$this->_val->validPhone($f3->get('phone'))) {
            $isValid = false;
            $f3->set("errors['phone']", "Please enter a U.S Phone Number");
        }

        return $isValid;
    }

    function checkProfile()
    {
        global $f3;
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
        $this->profile();
    }

    function validProfile()
    {
        global $f3;
        $isValid = true;
        if(!$this->_val->validEmail($f3->get('email'))) {
            $isValid = false;
            $f3->set("errors['email']", "You must provide an email");
        }
        return $isValid;
    }

    function checkActivities()
    {
        global $f3;
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
        $this->interests();
    }

    function validActivities()
    {
        global $f3;
        $isValid = true;
        if(!$this->_val->validOutdoor() || !$this->_val->validIndoor()) {
            $isValid = false;
            $f3->set("errors['activities']", "You must choose from the list");
        }
        return $isValid;
    }
}