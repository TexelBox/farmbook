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

    // unsafe query...
    public function query($query) {
        $result = $this->connection->query($query);
        return $result;
    }

    // safe query...
    // ASSUMED FORMAT (upto caller to respect this!!!)...
    // reference: https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection
    /* EXAMPLE...
    $stmt = $connection->prepare("INSERT INTO myTable (name, age) VALUES (?, ?)");
    $stmt->bind_param("si", $_POST['name'], $_POST['age']);
    $stmt->execute();
    $stmt->close();

    thus here...
    $preparedQuery === "INSERT INTO myTable (name, age) VALUES (?, ?)"
    $types === "si"
    $params === { $_POST['name'], $_POST['age'] }
    */
    public function preparedQuery($preparedQuery, $types, $params) {
        $stmt = $this->connection->prepare($preparedQuery);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    //TODO: could add more specific methods like select(...), insert(...), delete(...), etc. that call query()
}

?>