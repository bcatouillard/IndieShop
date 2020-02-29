<?php
Class Appartenir{
  private $db;
  private $insert;
  private $selectByJeux;
  private $update;

  public function __construct($db) {
      $this->db=$db;
      $this->insert=$db->prepare("insert into appartenir(idJeux,idGenre) values(:idJeux,:idGenre)");
      $this->selectByJeux = $db->prepare("select * from appartenir a inner join jeux j on a.idJeux=j.id where idJeux=:idJeux");
      $this->update = $db->prepare("update appartenir set idJeux=:idJeux, idGenre=:idGenre");
  }
  
  public function insert($idJeux, $idGenre){
        $r = true;
        $this->insert->execute(array(':idJeux'=>$idJeux, ':idGenre'=>$idGenre));
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
    
    public function update($idJeux,$idGenre){
        $r = true;
        $this->update->execute(array(':idJeux'=>$idJeux, ':idGenre'=>$idGenre));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
?>