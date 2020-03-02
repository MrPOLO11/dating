<?php

function validPersonalInformation()
{
    global $f3;
    $isValid = true;

    if (!validName($f3->get('fname'), $f3->get('lname'))) {
        $isValid = false;
        $f3->set("errors['fname']", "Please enter first name");
        $f3->set("errors['lname']", "Please enter last name");
    }

    if(!validAge($f3->get('age'))) {
        $isValid = false;
        $f3->set("errors['age']", "Please enter an age");
    }

    if(!validPhone($f3->get('phone'))) {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter a U.S Phone Number");
    }

    return $isValid;
}

function validProfile() {
    global $f3;
    $isValid = true;
    if(!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", "You must provide an email");
    }
    return $isValid;
}

function validActivities() {
    global $f3;
    $isValid = true;
    if(!validOutdoor() || !validIndoor()) {
        $isValid = false;
        $f3->set("errors['activities']", "You must choose from the list");
    }
    return $isValid;
}

function validName($fname, $lname)
{
    return !empty($fname) && ctype_alpha($fname) && !empty($lname) && ctype_alpha($lname);
}

function validAge($age)
{
    return !empty($age) && ctype_digit($age) && $age >= 18 && $age <= 118;
}


function validPhone($phone)
{
    return !empty($phone) && ctype_digit($phone) && strlen($phone) == 10;
}


function validEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validOutdoor()
{
    global $f3;
    $outdoorActs = $f3->get("selectOutdoorInterests");
    if(count($outdoorActs) == 0) {
        return true;
    } else {
        foreach ($outdoorActs AS $choice) {
            if (!in_array($choice, $f3->get("outdoorInterests"))) {
                return false;
            }
        }
        return true;
    }
}

function validIndoor()
{
    global $f3;
    $indoorActs = $f3->get("selectIndoorInterests");
    if(count($indoorActs) == 0) {
        return true;
    } else {
        foreach ($indoorActs AS $choice) {
            if(!in_array($choice, $f3->get("indoorInterests"))) {
                return false;
            }
        }
        return true;
    }
}