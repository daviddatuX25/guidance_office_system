<?php
class DataTable {
    private $db;

    public function __construct($dbInstance) {
        $this->db = $dbInstance;
    }

    // Helper function to build JOIN clauses
    private function buildJoins($joins) {
        $joinSql = '';
        foreach ($joins as $join) {
            $joinSql .= " {$join['type']} JOIN {$join['table']} ON {$join['on']}";
        }
        return $joinSql;
    }

    // Helper function to build WHERE clauses
    private function buildFilters($filters) {
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

    public function fetch($baseTable, $columns, $joins = [], $filters = []) {
        // Build SELECT and FROM
        $sql = "SELECT " . implode(", ", $columns) . " FROM $baseTable";

        // Add JOIN clauses
        $sql .= $this->buildJoins($joins);

        // Add WHERE clauses for filters
        [$filterSql, $filterParams] = $this->buildFilters($filters);
        $sql .= $filterSql;

        // Execute query
        $stmt = $this->db->query($sql, $filterParams);
        $data = $this->db->fetchAll($stmt);

        // Get total records
        $countSql = "SELECT COUNT(*) FROM $baseTable";
        $countSql .= $this->buildJoins($joins);
        $countSql .= $filterSql;
        $countStmt = $this->db->query($countSql, $filterParams);
        $totalRecords = $this->db->fetch($countStmt)['COUNT(*)'];

        // Return DataTables response
        return [
            "draw" => intval($_POST['draw'] ?? 0),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords, // No filtering applied on the client side
            "data" => $data
        ];
    }
}
?>