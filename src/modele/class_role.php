<?php
class Role{
    private $db;
    private $select;
    private $insert;
    private $selectByLibelle;
    private $update;
    private $delete;
    
    public function __construct($db){
        $this->db=$db;
        $this->select=$db->prepare("select * from role order by libelle");
        $this->insert=$db->prepare("insert into role(libelle) values(:libelle)");
        $this->selectByLibelle=$db->prepare("select * from role r where id=:id");
        $this->update=$db->prepare("update role set libelle=:libelle where id=:id");
        $this->delete=$db->prepare("delete from role where id=:id");
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
    
    public function selectByLibelle($id){  
        $this->selectByLibelle->execute(array(':id'=>$id));
        if ($this->selectByLibelle->errorCode()!=0){
             print_r($this->selectByLibelle->errorInfo());  
        }
        return $this->selectByLibelle->fetch();
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
}
?>