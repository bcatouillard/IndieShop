<?php
function actionGenre($twig,$db){
    $genre = new Genre($db);
    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ( $cocher as $id){
          $exec=$genre->delete($id); 
          if (!$exec){
             $form['valide'] = false;  
             $form['message'] = 'Problème de suppression dans la table genre';   
          }
          else{
              header("Location:index.php?page=genre");
              exit;
          }
        }
    
    }
    if(isset($_GET['id'])){
      $exec=$client->delete($_GET['id']);
      if(!$exec){
         $form['valide'] = false;  
         $form['message'] = 'Problème de suppression dans la table genre'; 
      }
      else{
         $form['valide'] = true;  
         $form['message'] = 'Genre supprimé avec succès';
         header("Location:index.php?page=genre");
         exit;
      }
    }

    if(isset($_POST['btAjouter'])){
        $libelle = $_POST['libelle'];
        $genre = new Genre($db);
        $exec = $genre->insert($libelle);
        if(!$exec){
            $form['valide'] = false;  
            $form['message'] = 'Problème d\'\ajout dans la table genre'; 
        }
        else{
            $form['valide'] = true;  
            $form['message'] = 'Genre ajouté avec succès';
            header("Location:index.php?page=genre");
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
    $r = $genre->selectCount();
    $nb = $r['nb'];
    $liste = $genre->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    echo $twig->render('genre.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionModifGenre($twig,$db){
    $form = array();
    if(isset($_GET['id'])){
        $genre = new Genre($db);
        $unGenre = $genre->selectByLibelle($_GET['id']);  
        if ($unGenre!=null){
            $form['genre'] = $unGenre;
            $form['valide'] = true;
        }
        else{
            $form['message'] = 'Genre incorrect';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
            $genre = new Genre($db);
            $libelle = $_POST['libelle'];
            $id = $_POST['id'];
            $exec=$genre->update($libelle,$id);
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
            $form['message'] = 'Genre non précisé';  
        }
    }
    echo $twig->render('genre-modif.html.twig', array('form'=>$form));
}
?>