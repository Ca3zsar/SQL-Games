<?php


namespace app\services\authentication\objects;


class User
{
    private $connection;
    private $tableName = "users";

    // object properties
    public $id;
    public $username;
    public $email;
    public $password;

    // constructor
    public function __construct($connection){
        $this->connection = $connection;
    }

    function create(){
        $query = "INSERT INTO " . $this->tableName . "
            SET
                username = :username,
                email = :email,
                password = :password";

        // prepare the query
        $statement = $this->connection->prepare($query);

        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->username));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

        // bind the values
        $statement->bindParam(':username', $this->username);
        $statement->bindParam(':email', $this->email);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $statement->bindParam(':password', $password_hash);

        // execute the query, also check if query was successful
        if($statement->execute()){
            return true;
        }

        return false;
    }
}