<?php
class Category{
  
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    function read() {
    
        $query = "SELECT
                    idCategories, name
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>    