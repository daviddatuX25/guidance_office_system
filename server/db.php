<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'guidance_db';
    private $username = 'root';
    private $password = '';
    protected $conn;

    private $db;
    private $stmt;
    private $table;
    
    public function __construct($table = null){
        $dsn = "mysql: host=" . $this->host . ";dbname=" . $this->db_name;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $this->table = $table;
        try{
            $this->db = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e){
            throw new RuntimeException("Database failed to connect: " . $e->getMessage());
        }
    }

    // Executes a raw query on the database
    public function query($sqlCode) {
        try {
            $this->stmt = $this->db->prepare($sqlCode);
            return $this->stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Returns the ID of the last inserted row
    public function getLastId() {
        try {
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

    // Bind helper function
    public function bind($stmt, $parameter, $value, $type = "") {
        if (is_array($value) || is_object($value)) {
            throw new InvalidArgumentException("Cannot bind array or object to SQL parameter");
        }
        if (empty($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $stmt->bindParam($parameter, $value, $type);
    }


    public function count($table, $where = [], $joins = []) {
        $table = $table ?? $this->table;
        try {
            // Use buildQuery to construct the query
            $result = $this->buildQuery($table, ['COUNT(*) AS total'], $where, $joins);
            if (!$result) {
                return 0;
            }
    
            $stmt = $result['stmt'];
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Read helper function
        // Example:
        // Columns -> ['col1','col2',...]
        // Joins -> [ ["type" => "", "table" => "", "condition" => "" ], [],... ]
        // Where -> ["column" => "", "operator" => "", "value" => "" ]
    private function buildQuery($table, $columns = [], $where = [], $joins = [], $limit = null, $offset = null, $order = []) {
        $table = $table ?? $this->table;
        try {
            // Build SELECT clause
            $select = empty($columns) || $columns === "*" ? '*' : implode(', ', $columns);
    
            // Build FROM clause
            $from = $table;
    
            // Build JOIN clauses
            $joinStmt = '';
            foreach ($joins as $join) {
                if (!isset($join['type'], $join['table'], $join['condition'])) {
                    throw new PDOException('Invalid join parameters');
                }
                $joinStmt .= " {$join['type']} JOIN {$join['table']} ON {$join['condition']}";
            }
    
            // Build WHERE clause
            $whereConditions = [];
            $bindValues = [];
            foreach ($where as $condition) {
                if (!isset($condition['column'], $condition['operator'], $condition['value'])) {
                    throw new PDOException('Invalid where condition');
                }
            
                if ($condition['operator'] === 'IN' && is_array($condition['value'])) {
                    $placeholders = implode(', ', array_fill(0, count($condition['value']), '?'));
                    $whereConditions[] = "{$condition['column']} IN ($placeholders)";
                    $bindValues = array_merge($bindValues, $condition['value']);
                } else {
                    $whereConditions[] = "{$condition['column']} {$condition['operator']} ?";
                    $bindValues[] = $condition['value'];
                }
            }
            $whereStmt = empty($whereConditions) ? '' : ' WHERE ' . implode(' AND ', $whereConditions);
    
            // Build ORDER BY clause
            $orderStmt = '';
            if (!empty($order)) {
                $orderParts = [];
                foreach ($order as $column => $direction) {
                    $orderParts[] = "$column $direction";
                }
                $orderStmt = ' ORDER BY ' . implode(', ', $orderParts);
            }
    
            // Build LIMIT and OFFSET clause
            $limitStmt = '';
            if ($limit !== null) {
                $limitStmt = " LIMIT $limit";
                if ($offset !== null) {
                    $limitStmt .= " OFFSET $offset";
                }
            }
    
            // Build SQL query
            $sql = "SELECT $select FROM $from $joinStmt $whereStmt $orderStmt $limitStmt";
    
            // Prepare statement
            $stmt = $this->db->prepare($sql);
    
            // Bind where values
            foreach ($bindValues as $index => $value) {
                $this->bind($stmt, $index + 1, $value);
            }
    
            return ['stmt' => $stmt, 'sql' => $sql];
        } catch (PDOException $e) {
            return false;
        }
    }
    // Read helper: Returns one result or false
    public function readOne($table, $columns = [],  $where = [], $joins = []) {
        $table = $table ?? $this->table;
        try {
            if (empty($where)) {
                return false; // No where condition provided
            }
    
            $result = $this->buildQuery($table, $columns, $where, $joins);
            if (!$result) {
                return false;
            }
    
            $stmt = $result['stmt'];
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row !== false ? $row : false;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // Read helper: Returns multiple results or empty array
    public function readAll($table, $columns = [], $where = [], $joins = [], $limit = null, $offset = null, $order = []) {
        $table = $table ?? $this->table;
        try {
            $result = $this->buildQuery($table, $columns, $where, $joins, $limit, $offset, $order);
            if (!$result) {
                return [];
            }
    
            $stmt = $result['stmt'];
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Create function (returns last inserted ID on success)
    public function create($table, $data) {
        $table = $table ?? $this->table;
        $columns = array_keys($data);
        $values = array_values($data);
        try {
            $sql = "INSERT INTO " . $table . " (" . implode(",", $columns) . ") VALUES (" . implode(",", array_fill(0, count($columns), "?")) . ")";
            $stmt = $this->db->prepare($sql);
            foreach ($values as $index => $value) {
                $this->bind($stmt, $index + 1, $value);
            }
            $success = $stmt->execute();
            return $success ? $this->getLastId() : false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($table, $data, $where) {
        $table = $table ?? $this->table;
        try {
            if (empty($data) || empty($where)) {
                throw new InvalidArgumentException("No data or where condition provided for update.");
            }
    
            // Prepare SET clause
            $setParts = [];
            $bindValues = []; // This will hold all bind values (data + where)
            foreach ($data as $column => $value) {
                $setParts[] = "`$column` = ?";
                $bindValues[] = $value; // Add data values to bindValues
            }
            $setStmt = implode(", ", $setParts);
    
            // Prepare WHERE clause
            $whereConditions = [];
            foreach ($where as $condition) {
                if (!isset($condition['column'], $condition['operator'], $condition['value'])) {
                    throw new InvalidArgumentException("Invalid where condition.");
                }
    
                if ($condition['operator'] === 'IN' && is_array($condition['value'])) {
                    $placeholders = implode(', ', array_fill(0, count($condition['value']), '?'));
                    $whereConditions[] = "`{$condition['column']}` IN ($placeholders)";
                    $bindValues = array_merge($bindValues, $condition['value']); // Add WHERE IN values to bindValues
                } else {
                    $whereConditions[] = "`{$condition['column']}` {$condition['operator']} ?";
                    $bindValues[] = $condition['value']; // Add WHERE values to bindValues
                }
            }
            $whereStmt = implode(" AND ", $whereConditions);
    
            // Build SQL query
            $sql = "UPDATE `$table` SET $setStmt WHERE $whereStmt";
            $stmt = $this->db->prepare($sql);
    
            // Bind all values (data + where)
            foreach ($bindValues as $index => $value) {
                $this->bind($stmt, $index + 1, $value);
            }
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Error: " . $e->getMessage());
            return false;
        } catch (InvalidArgumentException $e) {
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete($table, $where) {
        $table = $table ?? $this->table;
        try {
            if (empty($where)) {
                return false; // No where condition provided
            }

            // Build WHERE clause
            $whereConditions = [];
            $bindValues = [];
            foreach ($where as $condition) {
                if (!isset($condition['column'], $condition['operator'], $condition['value'])) {
                    throw new PDOException('Invalid where condition');
                }
            
                if ($condition['operator'] === 'IN' && is_array($condition['value'])) {
                    $placeholders = implode(', ', array_fill(0, count($condition['value']), '?'));
                    $whereConditions[] = "{$condition['column']} IN ($placeholders)";
                    $bindValues = array_merge($bindValues, $condition['value']);
                } else {
                    $whereConditions[] = "{$condition['column']} {$condition['operator']} ?";
                    $bindValues[] = $condition['value'];
                }
            }
            $whereStmt = empty($whereConditions) ? '' : ' WHERE ' . implode(' AND ', $whereConditions);

            $sql = "DELETE FROM " . $table . $whereStmt;
            $stmt = $this->db->prepare($sql);
             
            //  Bind Values
            foreach ($bindValues as $index => $value) {
                $this->bind($stmt, $index + 1, $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>