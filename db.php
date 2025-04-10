<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'guidance_db';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function query($sql, $params = array()) {
        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    // Create
    public function create($data = array(), $tableName) {
        if (empty($data) || !$tableName) return false;
        
        foreach($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags($value));
        }
        
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO " . $tableName . " ($columns) VALUES ($placeholders)";
        
        $stmt = $this->conn->prepare($sql);
        foreach($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Read
    // Read - Updated to use fetch() for single row
    public function read($data = array(), $tableName) {
        if (!$tableName) return false;
        
        $sql = "SELECT * FROM " . $tableName;
        $params = array();
        
        if (!empty($data)) {
            foreach($data as $key => $value) {
                $data[$key] = htmlspecialchars(strip_tags($value));
            }
            
            $conditions = array();
            foreach($data as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $conditions);
            $sql .= " LIMIT 1"; // Ensure only one row
        }
        
        $stmt = $this->query($sql, $params);
        return $this->fetch($stmt); // Changed from fetchAll to fetch
    }

    // Update
    public function update($data = array(), $whereIndex, $tableName) {
        if (empty($data) || !$whereIndex || !$tableName) return false;
        
        foreach($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags($value));
        }
        
        $setClause = array();
        $params = array();
        foreach($data as $key => $value) {
            $setClause[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $setClause = implode(", ", $setClause);
        $params[":id"] = $whereIndex;
        
        $sql = "UPDATE " . $tableName . " SET " . $setClause . " WHERE id = :id";
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount() > 0; // Returns true if rows were affected
    }

    // Delete
    public function delete($data = array(), $tableName) {
        if (!$tableName) return false;
        
        $sql = "DELETE FROM " . $tableName;
        $params = array();
        
        if (!empty($data)) {
            foreach($data as $key => $value) {
                $data[$key] = htmlspecialchars(strip_tags($value));
            }
            
            $conditions = array();
            foreach($data as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount() > 0; // Returns true if rows were deleted
    }

    public function fetchAll($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function execute($stmt) {
        return $stmt->execute();
    }

    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}
?>