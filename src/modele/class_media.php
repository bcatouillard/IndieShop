<?php
Class Media{
    private $db;
    private $selectByJeux;
    private $insert;
    private $update;
    private $selectCount;
    
    public function __construct($db) {
        $this->db = $db;
        $this->selectByJeux = $db->prepare("select * from media m inner join jeux j on m.idJeux=j.id where idJeux=:idJeux");
        $this->insert = $db->prepare("insert into media(id,idJeux, nom) values(:id,:idJeux, :nom)");
        $this->update = $db->prepare("update media set id=:id, idJeux=:idJeux, nom=:nom");
        $this->selectCount=$db->prepare("select count(*) as nb from media");
    }
    
    public function selectByJeux($idJeux){  
        $this->selectByJeux->execute(array(':idJeux'=>$idJeux));
        if ($this->selectByJeux->errorCode()!=0){
             print_r($this->selectByJeux->errorInfo());  
        }
        return $this->selectByJeux->fetch();
    }
    
    public function insert($id,$idJeux,$nom){
        $r = true;
        $this->insert->execute(array(':id'=>$id,':idJeux'=>$idJeux,':nom'=>$nom));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function update($id,$idJeux,$nom){
        $r = true;
        $this->update->execute(array(':id'=>$id,':idJeux'=>$idJeux, ':nom'=>$nom));
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
}