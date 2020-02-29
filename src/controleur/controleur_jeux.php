<?php
function actionJeux($twig,$db){
    $form = array();
    $jeux = new Jeux($db);
    $genre = new Genre($db);
    $portable = new Portabilite($db);
    
    $liste['genre']=$genre->select();
    $form['genre'] = $liste['genre'];
    $liste['portable']=$portable->select();
    $form['portable'] = $liste['portable'];
    
    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ( $cocher as $id){
          $exec=$jeux->delete($id); 
          if (!$exec){
             $form['valide'] = false;  
             $form['message'] = 'Problème de suppression dans la table jeux';   
          }
          else{
              header("Location:index.php?page=jeux");
              exit;
          }
        }
    
    }
    if(isset($_GET['id'])){
      $exec=$jeux->delete($_GET['id']);
      if(!$exec){
         $form['valide'] = false;  
         $form['message'] = 'Problème de suppression dans la table jeux'; 
      }
      else{
         $form['valide'] = true;  
         $form['message'] = 'Jeu supprimé avec succès';
      }
    }
    if(isset($_POST['btAjouter'])){
        $disponible = new Disponible($db);
        $appartenir = new Appartenir($db);
        $designation = $_POST['designation'];
        $description = $_POST['description'];
        $genre = $_POST['genre'];
        $genre2 = $_POST['genre2'];
        $portable = $_POST['portable'];
        $portable2 = $_POST['portable2'];
        $media = new Media($db);
        if(isset($_FILES['photo'])){
            if(!empty($_FILES['photo']['name'])){  
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '/var/www/html/Projet/Web/images/jeux/';
                if( !in_array( substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok ) ){
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                }
                else{
                    if( file_exists($_FILES['photo']['tmp_name']) && (filesize($_FILES['photo'] ['tmp_name'])) >  $taille_max){
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    }
                    else{
                        $photo = basename($_FILES['photo']['name']);                           
                        $photo=strtr($photo,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                        move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier.$photo); 
                        $r = $jeux->SelectCount();
                        $r['nb'] +=1;
                        $idJeux = $r['nb'];
                        $id = $idJeux;
                        $prix = $_POST['prix'];
                        $exec = $jeux->insert($id,$designation, $description, $prix);
                        $ins = $appartenir->insert($idJeux, $genre);
                        $ins = $appartenir->insert($idJeux, $genre2);
                        $exec = $disponible->insert($idJeux, $portable);
                        $exec = $disponible->insert($idJeux, $portable2);
                        $r = $media->selectCount();
                        $r['nb'] +=1;
                        $id = $r['nb'];
                        $exe = $media->insert($id,$idJeux, $photo);
                        if(!$exec){
                            $form['valide'] = false;  
                            $form['message'] = 'Problème d\'\ajout dans la table jeux'; 
                        }
                        else{
                            $form['valide'] = true;  
                            $form['message'] = 'Jeu ajouté avec succès';      
                        }
                    }
                }
            }
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
    $r = $jeux->selectCount();
    $nb = $r['nb'];
    $liste = $jeux->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    echo $twig->render('jeux.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionModifJeux($twig, $db){
    $form = array();
    if(isset($_GET['id'])){
        $disponible = new Disponible($db);
        $appartenir = new Appartenir($db);
        $genre= new Genre($db);
        $form['genre']=$genre->select();
        $portabilite= new Portabilite($db);
        $form['portable']=$portabilite->select();
        $jeux = new Jeux($db);
        $unJeu = $jeux->selectByID($_GET['id']);  
        $media = new Media($db);
        $unMedia = $media->selectByJeux($_GET['id']);
        if ($unJeu!=null){
            $form['jeux'] = $unJeu;
            $form['media'] = $unMedia;
            $form['valide'] = true;
        }
        else{
            $form['message'] = 'Jeu incorrect';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
            $jeux = new Jeux($db);
            $id = $_POST['id'];
            $designation = $_POST['designation'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $genre=$_POST['genre'];
            $genre2=$_POST['genre2'];
            $portable=$_POST['portable'];
            $portable=$_POST['portable2'];
            $media = new Media($db);
            if(isset($_FILES['photo'])){
                if(!empty($_FILES['photo']['name'])){  
                    $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                    $taille_max = 500000;
                    $dest_dossier = '/var/www/html/Projet/Web/images/jeux/';
                    if( !in_array( substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok ) ){
                        echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                    }
                    else{
                        if( file_exists($_FILES['photo']['tmp_name']) && (filesize($_FILES['photo'] ['tmp_name'])) >  $taille_max){
                            echo 'Votre fichier doit faire moins de 500Ko !';
                        }
                        else{
                            $photo = basename($_FILES['photo']['name']);                           
                            $photo=strtr($photo,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                            $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                            move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier.$photo); 
                            $exec=$jeux->update($id, $designation, $description, $prix);
                            $idJeux=$id;
                            if(isset($_POST['idmedia'])){
                                $id = $_POST['idmedia'];
                            }
                            else{
                                $r = $media->selectCount();
                                $r['nb'] +=1;
                                $id = $r['nb'];
                            }
                             
                            $test = $media->selectByJeux($idJeux);
                            if(isset($test['nom'])){
                                $exe=$media->update($id,$idJeux,$photo);
                            }
                            else{
                                $exe=$media->insert($id,$idJeux,$photo);
                            }
                            
                            $test1 = $appartenir->selectByJeux($idJeux);
                            if(isset($test1['designation'])){
                                $ex=$appartenir->update($idJeux,$genre);
                                $exe=$appartenir->update($idJeux,$genre2);

                            }
                            else{
                                $ex=$appartenir->insert($idJeux, $genre);
                                $exe=$appartenir->insert($idJeux, $genre2);
                            }
                            
                            $test2 = $disponible->selectByJeux($idJeux);
                            if(isset($test2['designation'])){
                                $ex=$disponible->update($idJeux,$portable);
                                $exe=$disponible->update($idJeux,$portable2);
                            }
                            else{
                                $ex=$disponible->insert($idJeux, $portable);
                                $exe=$disponible->insert($idJeux, $portable2);
                            }
                            
                            if(!$exec){
                                $form['conclure'] = false;  
                                $form['message'] = 'Échec de la modification'; 
                            }
                            else{
                                $form['conclure'] = true; 
                                $form['message'] = 'Modification réussie';  
                            }
                        }
                    }
                }
            }
            
        }
        else{
            $form['conclure'] = false; 
            $form['message'] = 'Jeu non précisé';  
        }
    }
    echo $twig->render('jeux-modif.html.twig', array('form'=>$form));
}
?>