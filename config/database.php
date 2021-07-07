<?php
class Database{
    private $user = 'root';
    private $password ='12345';
    private $db = 'diplom';
    private $host = 'localhost';
    public $conn;

    public function getConnection(){

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->password);
            $this->conn->exec("set names utf8");
        } 
        catch(PDOException $exception){
        echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    
    }
}
?>