<?php
class Account
{

    private $con;
    private $errorArray = array();
    public function __construct($con)
    {
        $this->con = $con;
    }

    public function updateDetails($fn, $ln, $em, $un)
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em, $un);

        if (empty($this->errorArray)) {
            // return $this->updatetUserDetails($fn,$ln,$un,$em);
            return $this->updateUserDetails($fn, $ln, $em, $un);
        }

        return false;

    }

    public function updatePassword($olp, $nwp, $nwp2, $un)
    {
        $this->validatePassword($nwp, $nwp2);
        if(empty($this->errorArray)){
            return $this->updateUserPasswordDetails($olp,$nwp,$un);
        }

        return false;
    }

    public function updateUserPasswordDetails($olp, $nwp, $un)
    {
        $olp = hash("sha512", $olp);
        if($this->isCorrectPassword($olp,$un)){
            $nwp = hash("sha512", $nwp);
            $query = $this->con->prepare("Update users set password=:pw where username=:un");
            $query->bindValue(":pw", $nwp);
            $query->bindValue(":un", $un);
    
            return $query->execute();
        }
        else{
            return false;
        }
        
    }

    public function isCorrectPassword($olp, $un)
    {
        
        $query = $this->con->prepare("Select password from users where username=:un");
        $query->bindValue(":un", $un);

        $query->execute();
        $correctPwd = $query->fetchColumn();

        if($olp==$correctPwd){
            return true;
        }
        else{
            array_push($this->errorArray, Constants::$oldPasswordDoNotMatch);
            return false;
        }
    }

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2)
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmail($em, $em2);
        $this->validatePassword($pw, $pw2);

        if (empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }

        return false;
    }



    public function login($un, $pw)
    {
        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("Select * from users where userName=:un and password=:pw");

        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);

        $query->execute();

        if ($query->rowCount() == 1) {
            return true;
        }

        array_push($this->errorArray, Constants::$loginFail);
        return false;

    }

    private function insertUserDetails($fn, $ln, $un, $em, $pw)
    {

        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("insert into users(firstName,lastName,userName,email,password)
                                    values(:fn,:ln,:un,:em,:pw)");

        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);

        return $query->execute();
    }

    private function updateUserDetails($fn, $ln, $em, $un)
    {
        $query = $this->con->prepare("update users set firstName=:fn,lastName=:ln,email=:em where username=:un");

        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);

        return $query->execute();
    }

    private function validateFirstName($fn)
    {
        if (strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharachters);
        }
    }

    private function validateLastName($ln)
    {
        if (strlen($ln) < 2 || strlen($ln) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharachters);
        }
    }

    private function validateUserName($un)
    {
        if (strlen($un) < 2 || strlen($un) > 25) {
            array_push($this->errorArray, Constants::$userNameCharachters);
            return;
        }

        $query = $this->con->prepare("Select * from users where userName=:un");
        $query->bindValue(":un", $un);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$userNameTaken);
        }
    }

    private function validateEmail($em, $em2)
    {
        if ($em != $em2) {
            array_push($this->errorArray, Constants::$emailDontMatch);
            return;
        }

        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$invalidEmail);
            return;
        }

        $query = $this->con->prepare("Select * from users where email=:em");
        $query->bindValue(":em", $em);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePassword($pw, $pw2)
    {
        if ($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordDontMatch);
            return;
        }

        if (strlen($pw) < 2 || strlen($pw) > 25) {
            array_push($this->errorArray, Constants::$passwordCharachters);
        }
    }

    private function validateNewEmail($em, $un)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$invalidEmail);
            return;
        }

        $query = $this->con->prepare("Select * from users where email=:em and username!=:username");
        $query->bindValue(":em", $em);
        $query->bindValue(":username", $un);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }
    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError()
    {
        if (!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
    }
}
?>