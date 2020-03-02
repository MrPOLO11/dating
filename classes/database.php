<?php

/**
 * Class Database
 *
 * SQL TABLES:
 * CREATE TABLE member (
 * member_id INT AUTO_INCREMENT PRIMARY KEY,
 * fname VARCHAR(30),
 * lname VARCHAR(30),
 * age INT,
 * gender VARCHAR(1),
 * phone VARCHAR(10),
 * email VARCHAR(30),
 * state VARCHAR(30),
 * seeking VARCHAR(1),
 * bio VARCHAR(30),
 * premium TINYINT,
 * image VARCHAR(30)
 * );
 *
 * CREATE TABLE interest (
 * interest_id INT AUTO_INCREMENT PRIMARY KEY,
 * interest VARCHAR(30),
 * type VARCHAR(15)
 * );
 *
 * CREATE TABLE `member-interest` (
 * member_id INT,
 * interest_id INT,
 * FOREIGN KEY (member_id) REFERENCES member(member_id),
 * FOREIGN KEY (interest_id) REFERENCES interest(interest_id)
 * );
 *
 */
class Database
{

    function connect()
    {

    }

    function insertMember()
    {

    }

    function getMembers()
    {

    }

    function getMember($member_id)
    {

    }

    function getInterests($member_id)
    {

    }
}
