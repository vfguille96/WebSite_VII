<?php
define("DATABASE", "WebSite");
define("DSN", "mysql:host=localhost;dbname=" . DATABASE);
define("USER", "root");
define("PASSWORD", "123");

define("TABLE_USERS", "users");
define("COLUMN_USERS_USERNAME", "username");
define("COLUMN_USERS_PASSWORD", "password");
define("COLUMN_USERS_NAME", "name");
define("COLUMN_USERS_SURNAME", "surname");


class Dao
{
    private $conn;
    public $error;

    function __construct()
    {
        try {
            $this->conn = new PDO(DSN, USER, PASSWORD);

        } catch (PDOException $e) {
            $this->error = "Connection error: " . $e->getMessage();
        }
    }

    function isConnected()
    {
        return isset($this->conn);
    }

    // To be protected from SQL Injection, we have to substitute all the variables in the query with placeholders, and then bind these variables.

    function validateUser($user, $password)
    {
        $sql = "SELECT * FROM " . TABLE_USERS . " WHERE " . COLUMN_USERS_USERNAME . "= ? AND " . COLUMN_USERS_PASSWORD . "= ?";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(1, $user);
        $statement->bindParam(2, $password);
        $statement->execute();
        $rows = $statement->fetchAll();
        return (count($rows) == 1) ? true : false;
    }

    function validateUserSignUp($user)
    {
        $sql = "SELECT * FROM " . TABLE_USERS . " WHERE " . COLUMN_USERS_USERNAME . "= ?";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(1, $user);
        $statement->execute();
        $rows = $statement->fetchAll();
        return (count($rows) == 1) ? true : false;
    }

    function showNameSurname($username)
    {
        $sql = "SELECT " . COLUMN_USERS_NAME . ", " . COLUMN_USERS_SURNAME . " FROM " . TABLE_USERS . " WHERE " . COLUMN_USERS_USERNAME . " = ?";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(1, $username);
        $statement->execute();
        return $statement->fetchAll();
    }

    function registerUser($username, $password, $name, $surname)
    {
        try {
            $sql = "INSERT INTO " . TABLE_USERS . " VALUES (?, ?, ?, ?)";
            $statement = $this->conn->prepare($sql);
            $statement->bindParam(1, $username);
            $statement->bindParam(2, $password);
            $statement->bindParam(3, $name);
            $statement->bindParam(4, $surname);
            $statement->execute();
            return ($this->validateUser($username, $password)) ? true : false;
        } catch (PDOException $e) {
            $this->error = "Error: " . $this->$e->getMessage();
            echo $this->error;
            return false;
        }
    }
}