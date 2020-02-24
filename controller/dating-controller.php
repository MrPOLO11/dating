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

    function interests() {
        $view = new Template();
        echo $view->render('views/interests.html');
    }

    function summary() {
        $view = new Template();
        echo $view->render('views/profile-summary.html');
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

    function validProfile() {
        global $f3;
        $isValid = true;
        if(!$this->_val->validEmail($f3->get('email'))) {
            $isValid = false;
            $f3->set("errors['email']", "You must provide an email");
        }
        return $isValid;
    }

    function validActivities() {
        global $f3;
        $isValid = true;
        if(!$this->_val->validOutdoor() || !$this->_val->validIndoor()) {
            $isValid = false;
            $f3->set("errors['activities']", "You must choose from the list");
        }
        return $isValid;
    }
}