<?php
require_once ("/home2/marcosri/config-dating.php");
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
    //PDO Object
    private $_dbh;

    function __construct()
    {
        $this->connect();
    }

    function connect()
    {
        try {
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function insertMember()
    {
        $sql = "INSERT INTO member
                VALUES (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio)";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':fname', $fname);
        $statement->bindParam(':lname', $lname);
        $statement->bindParam(':age', $age);
        $statement->bindParam(':gender', $gender);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':state', $state);
        $statement->bindParam(':seeking', $seeking);
        $statement->bindParam(':bio', $bio);

        $statement->execute();

        $id = $this->_dbh->lastInsertId();
    }

    function getMembers()
    {
        $sql = "SELECT * FROM member";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function getMember($member_id)
    {
        $sql = "SELECT * FROM member
                WHERE member_id = :member_id";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam('member_id', $member_id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function getInterests($member_id)
    {
        $sql = "SELECT * FROM interests
                WHERE `member-interest`.member_id = :member_id
                AND `member-interest`.interest_id = interests.interest_id";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam('member_id', $member_id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
