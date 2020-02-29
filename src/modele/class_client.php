<?php
Class Client{
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $selectByEmail;
    private $update;
    private $updatemdp;
    private $delete;
    private $selectCount;
    private $selectLimit;
    
    public function __construct($db){
        $this->db = $db;  
        $this->insert  =  $db->prepare("insert  into  client(email,  mdp,  pseudo,  idRole)  values(:email, :mdp, :pseudo, :idRole)");  
        $this->connect = $db->prepare("select email, idRole, mdp, pseudo from client where email=:email");
        $this->select  =  $db->prepare("select  *  from client c inner join role r where c.idRole = r.id order by pseudo");
        $this->selectByEmail = $db->prepare("select * from client where email=:email");
        $this->update = $db->prepare("update client set email=:email, pseudo=:pseudo, idRole=:role where email=:email");
        $this->updatemdp = $db->prepare("update client set mdp=:mdp where email=:email");
        $this->delete = $db->prepare("delete from client where email=:email");
        $this->selectCount=$db->prepare("select count(*) as nb from client");
        $this->selectLimit = $db->prepare("select * from client order by email limit :inf,:limite");

    }
    
    public function insert($email, $mdp, $pseudo, $idRole){ 
        $r = true;
        $this->insert->execute(array(':email'=>$email, ':mdp'=>$mdp,'pseudo'=>$pseudo, ':idRole'=>$idRole));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
        
    }
    public function connect($email){  
        $unClient = $this->connect->execute(array(':email'=>$email));
        if ($this->connect->errorCode()!=0){
             print_r($this->connect->errorInfo());  
        }
        return $this->connect->fetch();
    }
    
    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function selectByEmail($email){  
        $this->selectByEmail->execute(array(':email'=>$email));
        if ($this->selectByEmail->errorCode()!=0){
             print_r($this->selectByEmail->errorInfo());  
        }
        return $this->selectByEmail->fetch();
    }
    
    public function update($email, $role, $pseudo){
        $r = true;
        $this->update->execute(array(':email'=>$email, ':role'=>$role, ':pseudo'=>$pseudo));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function updatemdp($mdp, $email){
        $r = true;
        $this->updatemdp->execute(array(':mdp'=>$mdp,':email'=>$email));
        if ($this->updatemdp->errorCode()!=0){
             print_r($this->updatemdp->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function delete($email){
        $r = true;
        $this->delete->execute(array(':email'=>$email));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function selectCount(){
        $this->selectCount->execute();
        if ($this->selectCount->errorCode()!=0){
             print_r($this->selectCount->errorInfo());  
        }
        return $this->selectCount->fetch();   
    }
    
    public function selectLimit($inf, $limite){
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if ($this->selectLimit->errorCode()!=0){
             print_r($this->selectLimit->errorInfo());  
        }
        return $this->selectLimit->fetchAll();
    }
}
?>