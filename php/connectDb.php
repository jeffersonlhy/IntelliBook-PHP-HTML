<?php
include_once "session.php";

$domain = "YOUR_SQL_DOMAIN";

class Database{
    private static $db = null;
    private $connection;
    private $debug = False;


    private function __construct() {
        $domain = "YOUR_SQL_DOMAIN";
        if ($this->debug){
            $domain = "localhost";
        }
        $this->connection = new mysqli($domain, 'USER_NAME', 'PASSWORD', 'DBNAME');
    }

    function __destruct() {
        $this->connection->close();
    }

    public static function getConnection() {
        if (self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->connection;
    }
}

$db  = Database::getConnection();

