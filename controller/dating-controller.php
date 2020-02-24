<?php

class DatingController
{
    private $_f3; //Router

    public function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home() {
        $view = new Template();
        echo $view->render('views/home.html');
    }
}