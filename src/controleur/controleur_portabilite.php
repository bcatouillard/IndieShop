<?php
function actionPortabilite($twig, $db){
    $form = array();
    $portabilite = new Portabilite($db);
    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ( $cocher as $id){
          $exec=$portabilite->delete($id); 
          if (!$exec){
             $form['valide'] = false;  
             $form['message'] = 'Problème de suppression dans la table portabilité';   
          }
          else{
              header("Location:index.php?page=portabilite");
              exit;
          }
        }
    
    }
    if(isset($_GET['id'])){
      $exec=$portabilite->delete($_GET['id']);
      if(!$exec){
         $form['valide'] = false;  
         $form['message'] = 'Problème de suppression dans la table portabilité'; 
      }
      else{
         $form['valide'] = true;  
         $form['message'] = 'Portabilité supprimé avec succès';
         header("Location:index.php?page=portabilite");
         exit;
      }
    }

    if(isset($_POST['btAjouter'])){
        $type = $_POST['type'];
        $portabilite = new Portabilite($db);
        $exec = $portabilite->insert($type);
        if(!$exec){
            $form['valide'] = false;  
            $form['message'] = 'Problème d\'\ajout dans la table portabilité'; 
        }
        else{
            $form['valide'] = true;  
            $form['message'] = 'Portabilité ajoutée avec succès';
            header("Location:index.php?page=portabilite");
            exit;
      }
    }
    
    
    $limite=3;
    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }
    else{
        $nopage=$_GET['nopage'];
        $inf=$nopage * $limite;
    }
    $r = $portabilite->selectCount();
    $nb = $r['nb'];
    $liste = $portabilite->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    echo $twig->render('portable.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionModifPortabilite($twig, $db){
    $form = array();
    $form = array();
    if(isset($_GET['id'])){
        $portabilite = new Portabilite($db);
        $unePortabilite = $portabilite->selectByID($_GET['id']);  
        if ($unePortabilite!=null){
            $form['portabilite'] = $unePortabilite;
            $form['valide'] = true;
        }
        else{
            $form['message'] = 'Portabilité incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
            $portabilite = new Portabilite($db);
            $type = $_POST['type'];
            $id = $_POST['id'];
            $exec=$portabilite->update($type,$id);
            if(!$exec){
                $form['conclure'] = false;  
                $form['message'] = 'Échec de la modification'; 
            }
            else{
                $form['conclure'] = true; 
                $form['message'] = 'Modification réussie';  
            }
        }
        else{
            $form['conclure'] = false; 
            $form['message'] = 'Portabilité non précisée';  
        }
    }
    echo $twig->render('portable-modif.html.twig', array('form'=>$form));
}
?>