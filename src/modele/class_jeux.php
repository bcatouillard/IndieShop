<?php
Class Jeux{
    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    private $selectByID;
    private $selectCount;
    private $selectLimit;
    
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from jeux j inner join media m on j.id=m.idJeux inner join disponible d on d.idJeux=j.id inner join appartenir a on a.idJeux=j.id inner join portabilite p on d.idCompatibilite=p.id inner join genre g on g.id=a.idGenre  group by designation order by designation");
        $this->insert = $db->prepare("insert into jeux(id,designation, description, prix) values(:id,:designation, :description, :prix)");
        $this->update = $db->prepare("update jeux set designation=:designation, description=:description, prix=:prix where id=:id");
        $this->delete = $db->prepare("delete from jeux where id=:id");
        $this->selectByID = $db->prepare("select * from jeux where id=:id");
        $this->selectCount=$db->prepare("select count(*) as nb from jeux");
        $this->selectLimit = $db->prepare("select * from jeux order by designation limit :inf,:limite");
    }
    
    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function insert($id, $designation, $description, $prix){ 
        $r = true;
        $this->insert->execute(array(':id'=>$id,':designation'=>$designation, ':description'=>$description,'prix'=>$prix));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;     
    }
    
    public function update($id,$designation, $description, $prix){
        $r = true;
        $this->update->execute(array(':id'=>$id,':designation'=>$designation, ':description'=>$description, ':prix'=>$prix));
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
    
    public function selectByID($id){  
        $this->selectByID->execute(array(':id'=>$id));
        if ($this->selectByID->errorCode()!=0){
             print_r($this->selectByID->errorInfo());  
        }
        return $this->selectByID->fetch();
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