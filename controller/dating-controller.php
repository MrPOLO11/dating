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

}