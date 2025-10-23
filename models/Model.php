<?php


require_once __DIR__ . '/../config/database.php';

class Model {
    protected $db;
    
    public function __construct() {
        $this->db = getConnection();
    }
    
  
    protected function execute($sql, $params = []) {
        try {
           
            if (!empty($params) && is_array($params)) {
                $namedParams = array_keys($params);
                if (!empty($namedParams) && strpos($namedParams[0], ':') === 0) {
                 
                    foreach ($params as $key => $value) {
                        $sql = str_replace($key, '?', $sql);
                    }
                    $params = array_values($params);
                }
            }
            
            $stmt = mysqli_prepare($this->db, $sql);
            
            if (!$stmt) {
                error_log("Prepare failed: " . mysqli_error($this->db));
                return false;
            }
            
            
            if (!empty($params)) {
                $types = $this->getParamTypes($params);
                
               
                $bindParams = [$types];
                foreach ($params as $key => $value) {
                    $bindParams[] = &$params[$key];
                }
                
                call_user_func_array([$stmt, 'bind_param'], $bindParams);
            }
            
            mysqli_stmt_execute($stmt);
            return $stmt;
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
  
    private function getParamTypes($params) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }

    protected function fetchAll($sql, $params = []) {
        $stmt = $this->execute($sql, $params);
        if (!$stmt) return [];
        
        $result = mysqli_stmt_get_result($stmt);
        if (!$result) return [];
        
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $rows;
    }
    
   
    protected function fetchOne($sql, $params = []) {
        $stmt = $this->execute($sql, $params);
        if (!$stmt) return null;
        
        $result = mysqli_stmt_get_result($stmt);
        if (!$result) return null;
        
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        return $row;
    }
    
 
    protected function lastInsertId() {
        return mysqli_insert_id($this->db);
    }
}
