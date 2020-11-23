<?php

namespace Config;

require './connection.php';

use Config\Connection;

class WebCrawlerFunctions
{
    private $connection;

    public function __construct()
    {
        $con = new Connection();
        $this->connection = $con->getConnection();
    }

    
}
