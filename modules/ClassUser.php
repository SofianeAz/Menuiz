<?php 

// Sofiane 20/01/2022

class User {

    public $username;
    public $password;

    //set
    public function setUsername($username){
		return $this->username = $username;
	}
    public function setPassword($password){
		return $this->username = $password;
	}
    // public function setTypeuser($typeuser){
    //     return $this->typeuser = $typeuser;
    // }
    
    public function getUsername(){
		return $this->username;
	}
    public function getPassword(){
		return $this->password;
	}

    // function de check de l'utilisateur si le nom existe (retourne 1 si oui ou 0 si non);
    public function checkName(){
        $db = Connector::getInstance();
        $checkIfExist = $db->prepareQuery('SELECT 1 FROM `users` WHERE `username` = ?');
        $checkIfExist->bindValue(1, $this->username, PDO::PARAM_STR);         
        $checkIfExist->execute();
        return  $checkIfExist->fetchColumn();
    } 
    // function qui retourne le type d'utilisateur en string (ex: 'admin', 'technicien SAV', 'technicien HOTLINE')
    Public function returnType() {
        $db = Connector::getInstance();
        $query = $db->prepareQuery('SELECT typ_type from users as usr
                                 Join type_user as typ on typ.typ_user_id = usr.user_type_id 
                                 where username = ?');
        
        $query->BindValue(1, $this->username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch();
        return $result;
        }
    public function returnPw(){
            $db = Connector::getInstance();
            $checkIfExist = $db->prepareQuery("SELECT * FROM `users` WHERE `username` = ?");
            $checkIfExist->bindValue(1, $this->username, PDO::PARAM_STR); 
            $checkIfExist->execute();
            $result = $checkIfExist->fetchAll();
        return $result['password'];
    }
    // TO DO - sha256 crypter le password
}

?>




