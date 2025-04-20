<?php
class DataTable {
    private $db;

    public function __construct($dbInstance) {
        $this->db = $dbInstance;
    }

    // Helper function to build JOIN clauses
    protected function buildJoins($joins) {
        $joinSql = '';
        foreach ($joins as $join) {
            $joinSql .= " {$join['type']} JOIN {$join['table']} ON {$join['on']} ";
        }
        return $joinSql;
    }

    // Helper function to build filter
    protected function buildFilters($filters) {
        if (!empty($filters) && is_array($filters)) {
            $filterSql = 'WHERE 1=1';
            foreach ($filters as $key => $value) {
                if (is_array($value)) {
                    $safeValues = array_map('intval', $value); // Assumes integers
                    $filterSql .= " AND $key IN (" . implode(',', $safeValues) . ")";
                } else {
                    // Quote strings to avoid syntax errors
                    $safeValue = is_numeric($value) ? $value : "'" . addslashes($value) . "'";
                    $filterSql .= " AND $key = $safeValue";
                }
            }
            return $filterSql;
        }
        return '';
    }

    // Helper function to get total records
    protected function getTotalRecords($arr) {
        if (empty($arr)) return 0;
        $total = 0;
        foreach ($arr as $row) {
            if (isset($row['id'])) {
                $total++;
            }
        }
        return $total;
    }
    
    public function fetch($baseTable, $columns, $joins = [], $filters = []) {
        // Build SELECT and FROM
        $sql = "SELECT " . implode(", ", $columns) . " FROM $baseTable ";

        // Add JOIN clauses
        $sql .= $this->buildJoins($joins);

        // Add WHERE clauses for filters 
        $sql .= $this->buildFilters($filters);

        // Execute query with parameters
        $stmt = $this->db->query($sql);

// Disabled since AJAX PROCESSING is not used
        // // Paginate
        // if (isset($_POST['start']) && isset($_POST['length'])) {
        //     $sql .= " LIMIT :start, :length";
        //     $stmt->bindValue(':start', intval($_POST['start']), PDO::PARAM_INT);
        //     $stmt->bindValue(':length', intval($_POST['length']), PDO::PARAM_INT);
        // }

        // // Order by if provided
        // if (isset($_POST['order'])) {
        //     $orderBy = $_POST['columns'][$_POST['order'][0]['column']]['data'] . ' ' . $_POST['order'][0]['dir'];
        //     $sql .= " ORDER BY $orderBy";
        // }
        
        // Execute the final query
        $data = $this->db->fetchAll($stmt);

        // Get total records
        $totalRecords = $this->getTotalRecords($data);

        // Return DataTables response
        return [
            "draw" => intval($_POST['draw'] ?? 0),
            "recordsTotal" => $totalRecords,
            "data" => $data
        ];
    }
}
?>