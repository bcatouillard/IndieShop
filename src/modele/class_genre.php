<?php
Class Genre{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $update;
    private $selectCount;
    private $selectLimit;
    private $selectByLibelle;
    
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from genre group by libelle order by libelle");
        $this->insert = $db->prepare("insert into genre(libelle) values(:libelle)");
        $this->delete = $db->prepare("delete from genre where id=:id");
        $this->update = $db->prepare("update genre set libelle=:libelle where id=:id");
        $this->selectCount=$db->prepare("select count(*) as nb from genre");
        $this->selectLimit = $db->prepare("select * from genre order by libelle limit :inf,:limite");
        $this->selectByLibelle=$db->prepare("select libelle from genre g where id=:id");
    }
    
     public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }

    public function insert($libelle){
        $r = true;
        $this->insert->execute(array(':libelle'=>$libelle));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function update($libelle,$id){
        $r = true;
        $this->update->execute(array(':libelle'=>$libelle,':id'=>$id));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
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
    
    public function selectByLibelle($id){  
        $this->selectByLibelle->execute(array(':id'=>$id));
        if ($this->selectByLibelle->errorCode()!=0){
             print_r($this->selectByLibelle->errorInfo());  
        }
        return $this->selectByLibelle->fetch();
    }
}
?>