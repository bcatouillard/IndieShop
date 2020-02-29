<?php
Class Disponible{
    private $db;
    private $insert;
    private $selectByJeux;
    private $update;
    
    public function __construct($db) {
        $this->db=$db;
        $this->insert=$db->prepare("insert into disponible(idJeux,idCompatibilite) values(:idJeux, :idCompatibilite)");
        $this->selectByJeux = $db->prepare("select * from disponible d inner join jeux j on d.idJeux=j.id where idJeux=:idJeux");
        $this->update = $db->prepare("update disponible set idJeux=:idJeux, idCompatibilite=:idCompatibilite");
    }
    
    public function insert($idJeux, $idCompatibilite){
        $r = true;
        $this->insert->execute(array(':idJeux'=>$idJeux, ':idCompatibilite'=>$idCompatibilite));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function selectByJeux($idJeux){  
        $this->selectByJeux->execute(array(':idJeux'=>$idJeux));
        if ($this->selectByJeux->errorCode()!=0){
             print_r($this->selectByJeux->errorInfo());  
        }
        return $this->selectByJeux->fetch();
    }
    
    public function update($idJeux,$idCompatibilite){
        $r = true;
        $this->update->execute(array(':idJeux'=>$idJeux, ':idCompatibilite'=>$idCompatibilite));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
?>