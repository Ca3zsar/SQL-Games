<?php


namespace app\services\authentication\objects;


class User
{
    private $connection;
    private String $tableName = "users";

    // object properties
    public int $id;
    public String $username;
    public String $email;
    public String $password;

    // constructor
    public function __construct($connection=null){
        $this->connection = $connection;
    }

    function create(): bool
    {
        $query = "INSERT INTO " . $this->tableName . "
            SET
                username = :username,
                email = :email,
                password = :password";

        // prepare the query
        $statement = $this->connection->prepare($query);

        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
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

    public function userExists($where)
    {
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = $this->connection->prepare("SELECT * FROM $this->tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}