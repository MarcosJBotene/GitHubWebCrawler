<?php

namespace Config;

class Connection
{

    private $username;
    private $password;
    private $database;
    private $host;

    public function __construct()
    {
        $this->username = 'root';
        $this->password = '';
        $this->host = 'localhost';
        $this->database = 'web-crawler';
    }

    public function getConnection()
    {

        $con = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->username, $this->password);

        return $con;
    }
}
