<?php
class Product{
 
    private $conn;
 
    public $id;
    public $name;
    public $price;
    public $image;
    public $description;
    public $brand;
    public $category;
    public $date;

 
    public function __construct($db) {
        $this->conn = $db;
    }
    function create() {

 
        $query ="INSERT INTO diplom.product (name,price,image,description,brand,date,IdCategory) VALUES (:name,:price,:image,:description,:brand,:date,:category)";
 
        $stmt = $this->conn->prepare($query);
    

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->brand=htmlspecialchars(strip_tags($this->brand));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->date=htmlspecialchars(strip_tags($this->date));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':date', $this->date);
      
        if($stmt->execute()) {
            return true;
        }
    
        return false;
    
    }
    function search($keywords){

        $query = "SELECT c.name as category_name, p.idProduct, p.name, p.description, p.price,p.brand, p.idCategory  FROM
        diplom.product p
        LEFT JOIN
            diplom.categories c
                ON p.idCategory = c.idCategories
    WHERE
        p.name LIKE ? OR p.description LIKE ?";
                
    
        $stmt = $this->conn->prepare($query);
    
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // привязка 
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        
    
        // // выполняем запрос 
        $stmt->execute();
    
        return $stmt;
    }
    function read() {
    
        $query = "SELECT  p.idProduct, p.name, p.description,p.image, p.price,p.brand,p.count, p.idCategory, c.name as category_name  FROM
        diplom.product p
        LEFT JOIN
            diplom.categories c
                ON p.idCategory = c.idCategories";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    function read_category_products($id) {
    
        $query = "SELECT  p.idProduct, p.name, p.description,p.image, p.price,p.brand,p.count, p.idCategory, c.name as category_name  FROM
        diplom.product p
        LEFT JOIN
            diplom.categories c
                ON p.idCategory = c.idCategories WHERE p.idCategory=?" ;

        $stmt = $this->conn->prepare($query);
            
        $id=htmlspecialchars(strip_tags($id));

        
        $stmt->bindParam(1, $id);

        
        $stmt->execute();

        return $stmt;
    }
}
