<?php
class Order{

    private $conn;
    
    public $idOrder;
    public $idProduct;
    public $idClient;
    public $count_product;
    public $date;
    public $status;
     
    public function __construct($db) {
        $this->conn = $db;
    }
    function addOrder() {
        $query ="INSERT INTO diplom.order (status,date,idClient) VALUES (1,:date,:idClient)";
 
        $stmt = $this->conn->prepare($query);

        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->idClient=htmlspecialchars(strip_tags($this->idClient));

        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':idClient', $this->idClient);

        if($stmt->execute()) {
            return $this->conn->lastInsertId('diplom.order');
        return false;
    }
}
    function addOrderProducts($idO,$idP,$count){
        $query ="INSERT INTO diplom.orderproducts(idOrder,idProduct,count_product) VALUES(?,?,?)";
 
        $stmt = $this->conn->prepare($query);

        $idO=htmlspecialchars(strip_tags($idO));
        $idP=htmlspecialchars(strip_tags($idP));
        $count=htmlspecialchars(strip_tags($count));
    
        // привязка 
        $stmt->bindParam(1, $idO);
        $stmt->bindParam(2, $idP);
        $stmt->bindParam(3, $count);
        if($stmt->execute()){
            return true;
        }
        return false;

    }
    function getOrdersAdmin(){
     
        $query = "SELECT  o.idOrder, o.date, c.firstname, c.lastname, c.phone, c.email FROM
        diplom.order o
        LEFT JOIN
            diplom.client c
                ON o.idClient = c.idClient WHERE o.status=1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    function getOrderProductsAdmin($id){
     
        $query = "SELECT o.count_product,p.name,p.price,p.image FROM
        diplom.orderproducts o
        LEFT JOIN
            diplom.product p
                ON o.idProduct = p.idProduct WHERE o.idOrder=?" ;

        $stmt = $this->conn->prepare($query);
            
        $id=htmlspecialchars(strip_tags($id));
 
        $stmt->bindParam(1, $id);

        
        $stmt->execute();

        return $stmt;
    }

} 
 ?>   