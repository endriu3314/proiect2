<?php
        error_reporting(0);

class User
{
    private $db_table = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $hash;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register()
    {
        $query = "INSERT INTO " . $this->db_table . "
        SET name = :name, email = :email, password = :password";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = hash('sha256', $this->password);

        if (empty($this->name)) {
            throw new Exception('Name required.');
        }

        if (empty($this->email)) {
            throw new Exception('Email required.');
        }

        if (empty($this->password)) {
            throw new Exception('Password required.');
        }

        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $this->password, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function login()
    {
        $query = "SELECT id, name, email FROM " . $this->db_table . " WHERE (name = :name OR email = :email) AND password = :password";

        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = hash('sha256', $this->password);

        if (empty($this->name)) {
            throw new Exception('Name required.');
        }

        if (empty($this->email)) {
            throw new Exception('Email required.');
        }

        if (empty($this->password)) {
            throw new Exception('Password required.');
        }

        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $this->password, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            $id = $result->id;
            $name = $result->name;
            $email = $result->email;

            $query ="UPDATE " . $this->db_table . " SET hash = :hash WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $hash = base64_encode($this->name . ':' . $this->email . ':' . date("h:i:sa"));

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":hash", $hash, PDO::PARAM_STR);

            $stmt->execute();

            $arr = array(
                "user" => array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email
                ),
                "hash" => $hash,
            );

            $returnArr = array();
            $returnArr["body"] = array();
            $returnArr["success"] = true;
            $returnArr["message"] = "Logged in";

            array_push($returnArr["body"], $arr);

            return $returnArr;
        } else {
            throw new Exception('Error logging in.');
        }
    }
    

    public function getAll()
    {
        $query = "SELECT id, name, email FROM " . $this->db_table;

        $stmt = $this ->conn->prepare($query);

        $stmt->execute();

        $usersArr = array();
        $usersArr["body"] = array();
        $usersArr["count"] = $stmt->rowCount();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            foreach ($users as $user) {
                extract($user);

                $arr = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                );

                array_push($usersArr["body"], $arr);
            }
            $usersArr["success"] = true;
            $usersArr["message"] = "Retrieved users.";
            return json_encode($usersArr);
        } else {
            throw new Exception("No records found.");
        }
    }

    public function verifyAuthorization()
    {
        $query = "SELECT id, hash FROM " . $this->db_table . " WHERE hash = :hash";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":hash", $this->hash, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            throw new Exception('Cannot verify');
        }
    }
}
