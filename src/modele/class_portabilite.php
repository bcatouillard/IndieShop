<?php
Class Portabilite{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $update;
    private $selectByID;
    private $selectCount;
    private $selectLimit;
    
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from portabilite group by type order by type");
        $this->insert = $db->prepare("insert into portabilite(type) values(:type)");
        $this->delete = $db->prepare("delete from portabilite where id=:id");
        $this->update = $db->prepare("update portabilite set type=:type where id=:id");
        $this->selectCount=$db->prepare("select count(*) as nb from portabilite");
        $this->selectLimit = $db->prepare("select * from portabilite order by type limit :inf,:limite");
        $this->selectByID=$db->prepare("select type from portabilite  where id=:id");
    }
    
    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function insert($type){
        $r = true;
        $this->insert->execute(array(':type'=>$type));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
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
    
    public function update($type,$id){
        $r = true;
        $this->update->execute(array(':type'=>$type,':id'=>$id));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
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
    
    public function selectByID($id){  
        $this->selectByID->execute(array(':id'=>$id));
        if ($this->selectByID->errorCode()!=0){
             print_r($this->selectByID->errorInfo());  
        }
        return $this->selectByID->fetch();
    }
}