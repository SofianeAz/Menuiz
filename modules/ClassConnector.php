<?php

class Connector
{  
    private $host;
    private $db; 
    private $username;
    private $password;
    private $con;
    private static $instance;

    // function de connexion
    private function connect() {  
        $this->host = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->db = 'Menuiz';
        try { 
             $con = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8', $this->username, $this->password);
             $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
             $this->con = $con;                 
        } catch(PDOException $e){
            die("Erreur:".$e->getMessage());
        }             
    }
    // static connexion function
    public static function getInstance(){
        if(static::$instance === NULL){
            static::$instance = new Connector();
            static::$instance->connect();
        } 
        return static::$instance;        
    }
    public function prepareQuery($param){
        return $this->con->prepare($param);
    }
    // // function check si l'utilisateur est déjà dans la database
    public function checkName($paramName){
            $checkIfExist = $this->prepareQuery('SELECT 1 FROM `users` WHERE `username` = ?');
            $checkIfExist->bindValue(1, $paramName, PDO::PARAM_STR);         
            $checkIfExist->execute();
            return  $checkIfExist->fetchColumn();
    } 
    public function checkPassword($param, $param2){
            // $encryptedPw = password_hash($param, PASSWORD_DEFAULT);
            $checkIfExist = $this->con->prepare("SELECT * FROM `users` WHERE `username` = ?");
            $checkIfExist->bindValue(1, $param, PDO::PARAM_STR); 
            // $encryptedPw,
            $checkIfExist->execute();
            $result = $checkIfExist->fetchAll(PDO::FETCH_ASSOC);
            return password_verify($param2, $result['password']);
    }
    public function registerUser($param1, $param2, $param3){
                $encryptedPw = password_hash($param2, PASSWORD_DEFAULT);
                $register = $this->con->prepare('INSERT into `users` (`username`, `password`, `user_type_id`)
                                          VALUES(?, ?, ?)');
                $register->bindValue(1, $param1, PDO::PARAM_STR);
                $register->bindValue(2, $encryptedPw, PDO::PARAM_STR);  
                $register->bindValue(3, $param3, PDO::PARAM_INT);               
                $register->execute();
    }

}  

?>

