<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "user_management";
    private $connection;
    
    public function __construct() {
        $this->connect();
        $this->createDatabase();
        $this->createTable();
    }
    
    private function connect() {
        try {
            // First connect without database to create it if it doesn't exist
            $this->connection = new PDO("mysql:host={$this->host}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    private function createDatabase() {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS {$this->database} CHARACTER SET utf8 COLLATE utf8_general_ci";
            $this->connection->exec($sql);
            
            // Now connect to the database
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database creation failed: " . $e->getMessage());
        }
    }
    
    private function createTable() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                age INT NOT NULL,
                status TINYINT DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->connection->exec($sql);
            
            // Insert sample data if table is empty
            $this->insertSampleData();
        } catch(PDOException $e) {
            die("Table creation failed: " . $e->getMessage());
        }
    }
    
    private function insertSampleData() {
        try {
            $stmt = $this->connection->query("SELECT COUNT(*) FROM users");
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                $sampleData = [
                    ['John', 25],
                    ['Sarah', 30],
                    ['Michael', 22]
                ];
                
                $sql = "INSERT INTO users (name, age, status) VALUES (?, ?, 1)";
                $stmt = $this->connection->prepare($sql);
                
                foreach ($sampleData as $user) {
                    $stmt->execute($user);
                }
            }
        } catch(PDOException $e) {
            // Sample data insertion failed, but this is not critical
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function addUser($name, $age) {
        try {
            $sql = "INSERT INTO users (name, age, status) VALUES (?, ?, 1)";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([$name, $age]);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function getAllUsers() {
        try {
            $sql = "SELECT * FROM users ORDER BY id DESC";
            $stmt = $this->connection->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function toggleUserStatus($id) {
        try {
            $sql = "UPDATE users SET status = CASE WHEN status = 1 THEN 0 ELSE 1 END WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>