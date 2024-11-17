<?php

class DatabaseConnection
{
    private static $instance = null; // Singleton instance
    private $connection;

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbName = "MagdyYacoubHMS";

    // Private constructor to prevent multiple instances
    private function __construct()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbName);

        // Check for connection errors
        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    // Get the singleton instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    // Get the database connection
    public function getConnection()
    {
        return $this->connection;
    }

    // Close the connection (optional cleanup method)
    public function closeConnection()
    {
        if ($this->connection) {
            $this->connection->close();
            self::$instance = null;
        }
    }
}

// Helper function to return the connection
function returnConnection()
{
    return DatabaseConnection::getInstance()->getConnection();
}

?>
