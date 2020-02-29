<?php
function getPage($db){
    $lesPages['accueil'] = 'actionAccueil;0';
    $lesPages['boutique'] = 'actionBoutique;0';
    $lesPages['support'] = 'actionSupport;2';
    $lesPages['mention'] = 'actionMention;2';
    $lesPages['jeux'] = 'actionJeux;1';
    $lesPages['jeux-modif'] = 'actionModifJeux;1';
    $lesPages['genre'] = 'actionGenre;1';
    $lesPages['genre-modif'] = 'actionModifGenre;1';
    $lesPages['portabilite'] = 'actionPortabilite;1';
    $lesPages['portabilite-modif'] = 'actionModifPortabilite;1';
    $lesPages['client'] = 'actionClient;1';
    $lesPages['client-modif'] = 'actionModifClient;1';
    $lesPages['connexion'] = 'actionConnexion;0';
    $lesPages['deconnexion'] = 'actionDeconnexion;2';
    $lesPages['inscription'] = 'actionInscription;0';
    $contenu = $lesPages['accueil'];
    
    if ($db!=null){
        if(isset($_GET['page'])){
            $page = $_GET['page']; }
        else{
            $page = 'accueil';
        }
        if (!isset($lesPages[$page])){
            $page = 'accueil'; 
        }
    }

$explose = explode(";",$lesPages[$page]);
$role = $explose[0];
  
if ($role != 0){
    if(isset($_SESSION['login'])){  
      if(isset($_SESSION['role'])){    
         if($role!=$_SESSION['role']){
           $contenu = 'actionAccueil';  
         }
         else{
           $contenu = $explose[0]; 
         }
      }
      else{
        $contenu = 'actionAccueil';   
      }
    }
    else{
      $contenu = 'actionAccueil';  
    }
  }else{
    $contenu = $explose[0];
  }
return $contenu; 
}
?>