<?php
class User
{
    private $con;
    private $sqlData;

    public function __construct($con, $username)
    {
        $this->con = $con;


        $query = $this->con->prepare("select * from users where username=:username");
        $query->bindValue(":username", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

    }

    public function getFirstName(){
        return $this->sqlData["firstName"];
    }

    public function getLastName(){
        return $this->sqlData["lastName"];
    }

    public function getEmail(){
        return $this->sqlData["email"];
    }
}