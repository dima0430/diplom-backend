<?php
class Comment{

    private $conn;

 
    public $id;
    public $clientText;
    public $adminText;
    public $date;
    public $status;
    public $idClient;
    public $idProduct;
    public $firstname;
    public $lastname;


    public function __construct($db) {
        $this->conn = $db;
    }

    function addComment() {
        $query ="INSERT INTO diplom.comment (clientText,date,idClient,idProduct) VALUES (:clientText,:date,:idClient,:idProduct)";
 
        $stmt = $this->conn->prepare($query);

        $this->clientText=htmlspecialchars(strip_tags($this->clientText));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->idClient=htmlspecialchars(strip_tags($this->idClient));
        $this->idProduct=htmlspecialchars(strip_tags($this->idProduct));

        $stmt->bindParam(':clientText', $this->clientText);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':idClient', $this->idClient);
        $stmt->bindParam(':idProduct', $this->idProduct);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    function getComments($id) {
    
        $query = "SELECT  c.idComment, c.clientText,c.date, cl.firstname,cl.lastname FROM
        diplom.comment c
        LEFT JOIN
            diplom.client cl
                ON c.idClient = cl.idClient WHERE idProduct=?";

        $stmt = $this->conn->prepare($query);
        $id=htmlspecialchars(strip_tags($id));

        
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt;
    }
    function getLastComment($id) {
    
        $query = "SELECT  c.idComment, c.clientText,c.date, cl.firstname,cl.lastname FROM
        diplom.comment c
        LEFT JOIN
            diplom.client cl
                ON c.idClient = cl.idClient WHERE idProduct=? ORDER BY idComment DESC LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $id=htmlspecialchars(strip_tags($id));

        
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt;
    }
}