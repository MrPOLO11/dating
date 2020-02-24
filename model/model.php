<?php

class Model
{
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
}
