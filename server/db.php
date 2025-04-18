<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'guidance_db';
    private $username = 'root';
    private $password = '';
    protected $conn;

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

   public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $value, $type);
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

    // Helper function to build JOIN clauses
    public function buildJoins($joins) {
        $joinSql = '';
        foreach ($joins as $join) {
            $joinSql .= " {$join['type']} JOIN {$join['table']} ON {$join['on']}";
        }
        return $joinSql;
    }

    // Helper function to build WHERE clauses
    public function buildFilters($filters) {
        $filterSql = '';
        $params = [];
        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $filterSql = " WHERE " . implode(" AND ", $conditions);
        }
        return [$filterSql, $params];
    }

    // Helper function to build search conditions
    public function buildSearch($searchValue, $searchableColumns) {
        $searchSql = '';
        $params = [];
        if (!empty($searchValue)) {
            $conditions = [];
            foreach ($searchableColumns as $column) {
                $conditions[] = "$column LIKE :search";
            }
            $searchSql = " (" . implode(" OR ", $conditions) . ")";
            $params[':search'] = "%$searchValue%";
        }
        return [$searchSql, $params];
    }

    // Helper function to build pagination
    public function buildPagination($start, $length) {
        return " LIMIT :start, :length";
    }

    // Simplified datatableFetch function
    public function datatableFetch($baseTable, $columns, $joins = [], $filters = [], $searchableColumns = [], $orderColumn = 'id', $orderDir = 'ASC', $start = 0, $length = 10, $searchValue = '') {
        // Build SELECT and FROM
        $sql = "SELECT " . implode(", ", $columns) . " FROM $baseTable";

        // Add JOIN clauses
        $sql .= $this->buildJoins($joins);

        // Add WHERE clauses for filters
        [$filterSql, $filterParams] = $this->buildFilters($filters);
        $sql .= $filterSql;

        // Add search conditions
        [$searchSql, $searchParams] = $this->buildSearch($searchValue, $searchableColumns);
        if (!empty($searchSql)) {
            $sql .= empty($filterSql) ? " WHERE $searchSql" : " AND $searchSql";
        }

        // Add ORDER BY and LIMIT
        $sql .= " ORDER BY $orderColumn $orderDir";
        $sql .= $this->buildPagination($start, $length);

        // Prepare and execute
        $stmt = $this->conn->prepare($sql);
        foreach (array_merge($filterParams, $searchParams) as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':length', $length, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch data
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total records
        $countSql = "SELECT COUNT(*) FROM $baseTable";
        $countSql .= $this->buildJoins($joins);
        $countSql .= $filterSql;
        $countStmt = $this->conn->prepare($countSql);
        foreach ($filterParams as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $totalRecords = $countStmt->fetchColumn();

        // Return DataTables response
        return [
            "draw" => intval($_POST['draw'] ?? 0),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => count($data),
            "data" => $data
        ];
    }
}
?>