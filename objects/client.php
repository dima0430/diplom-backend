<?php
class Client{

    private $conn;

 
    public $id;
    public $firstname;
    public $lastname;
    public $phone;
    public $email;
    public $password;


    public function __construct($db) {
        $this->conn = $db;
    }

    // Создание нового пользователя 
    function create() {


        $query ="INSERT INTO diplom.client (firstname,lastname,phone,email,password) VALUES (:firstname,:lastname,:phone,:email,:password)";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
    
        // инъекция 
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
    
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $password_hash);
        
        if($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    function emailExists(){
 
        // запрос, чтобы проверить, существует ли электронная почта 
        $query = "SELECT idClient, firstname, lastname,phone, password
                FROM diplom.client
                WHERE email = ?
                LIMIT 0,1";
     
        // подготовка запроса 
        $stmt = $this->conn->prepare( $query );
     
        // инъекция 
        $this->email=htmlspecialchars(strip_tags($this->email));
     
        // привязываем значение e-mail 
        $stmt->bindParam(1, $this->email);
     
        // выполняем запрос 
        $stmt->execute();
     
        // получаем количество строк 
        $num = $stmt->rowCount();
     
        // если электронная почта существует, 
        // присвоим значения свойствам объекта для легкого доступа и использования для php сессий 
        if($num>0) {
     
            // получаем значения 
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // присвоим значения свойствам объекта 
            $this->id = $row['idClient'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->phone = $row['phone'];
            $this->password = $row['password'];
     
            // вернём 'true', потому что в базе данных существует электронная почта 
            return true;
        }
     
        // вернём 'false', если адрес электронной почты не существует в базе данных 
        return false;
    }
     
    // здесь будет метод update()
}
?>