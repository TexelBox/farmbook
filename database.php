<?php

// ==================DATABASE BOILERPLATE==================
//NOTE: similar structure to https://www.binpress.com/using-php-with-mysql/
//NOTE: this class performs no sanitization. That should be done by caller beforehand.
//TODO: improve code by consulting https://www.acunetix.com/blog/articles/prevent-sql-injection-vulnerabilities-in-php-applications/
class Database {
    private $connection = NULL;
    
    public function __construct() {
        $configFilePath = "private/config.ini";
        if (!file_exists($configFilePath)) die("ADMIN ERROR: MISSING/WRONG CONFIG FILE!!!");

        $config = parse_ini_file($configFilePath);
        //TODO: error checking on failed parse???
        $this->connection = new mysqli($config["host"], $config["username"], $config["password"], $config["dbname"]);
        if ($this->connection->connect_error) {
            //TODO: handle this error better (log SQL errors to a file, and only show generic messages to user (non-related to SQL))
            die("Database connection error: " . $this->connection->connect_error);
        }
    }

    //NOTE: gets called after script finishes (regardless of success or die)
    public function __destruct() {
        if (!is_null($this->connection)) {
            $this->connection->close();
        }
    }

    public function query($query) {
        $result = $this->connection->query($query);
        return $result;
    }

    //TODO: could add more specific methods like select(...), insert(...), delete(...), etc. that call query()
}

?>