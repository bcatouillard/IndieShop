<?php
function actionClient($twig,$db){
    $client = new Client($db);
    
    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ( $cocher as $email){
          $exec=$client->delete($email); 
          if (!$exec){
             $form['valide'] = false;  
             $form['message'] = 'Problème de suppression dans la table client';   
          }
          else{
              header("Location:index.php?page=client");
              exit;
          }
        }
    
    }
    if(isset($_GET['email'])){
      $exec=$client->delete($_GET['email']);
      if(!$exec){
         $form['valide'] = false;  
         $form['message'] = 'Problème de suppression dans la table client'; 
      }
      else{
         $form['valide'] = true;  
         $form['message'] = 'Client supprimé avec succès';
         header("Location:index.php?page=client");
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
    $r = $client->selectCount();
    $nb = $r['nb'];
    $liste = $client->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    echo $twig->render('client.html.twig', array('liste'=>$liste));
}

function actionModifClient($twig,$db){
    $form = array();
    if(isset($_GET['email'])){
       $client = new Client($db);
       $unClient = $client->selectByEmail($_GET['email']);  
        if ($unClient!=null){
            $form['client'] = $unClient;
            $role = new Role($db);
            $liste = $role->select();
            $form['roles']=$liste;
            $form['valide'] = true;
        }
        else{
            $form['valide'] = false;
            $form['message'] = 'Client incorrect';  
        }
    }
    else{
        if(isset($_POST['btModifier'])){
            $client = new Client($db);
            $pseudo = $_POST['pseudo'];
            $role = $_POST['role'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $mdp2 = $_POST['mdp2'];
            if(!empty($mdp)){
                if($mdp == $mdp2){
                    $exe=$utilisateur->update($email, $role, $nom, $prenom);
                    $exec=$utilisateur->updatemdp(password_hash($mdp,PASSWORD_DEFAULT),$email);
                    if(!$exec or !$exe){
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
                    $form['message'] = 'Mot de passe non identiques';   
                }
            }
            else{
             $form['conclure'] = false;
             $form['message'] = 'Mot de passe vide';   
            }
        }
        else{
            $form['conclure'] = false;
            $form['message'] = 'Client non précisé';
        }
    }
    echo $twig->render('client-modif.html.twig',array('form'=>$form));
    }
?>