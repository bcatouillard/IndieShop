<?php
function actionAccueil($twig,$db){
    echo $twig->render('index.html.twig', array());
}
    
function actionMention($twig){
    echo $twig->render('mention.html.twig', array());
}    

function actionBoutique($twig,$db){
    $jeux = new Jeux($db);
    $liste=$jeux->select();
    echo $twig->render('boutique.html.twig', array('liste'=>$liste));
}

function actionSupport($twig){
    $form = array();
    $form['valide'] = false;
    if(isset($_POST['btEnvoyer'])){
        $email = $_POST['email'];
        $sujet = $_POST['sujet'];
        $message = $_POST['message'];
        $header = "From: ".$email."catouillard.benjamin@gmail.com".$passage_ligne;
        mail($email,$sujet,$message,$header);
        $form['valide'] = true;
        $form['message'] = "Message envoyé";
    }
    echo $twig->render('support.html.twig', array('form'=>$form));
}

function actionConnexion($twig,$db){
    $form = array();
    if(isset($_POST['btConnecter'])){
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $client = new Client($db);
        $unClient = $client->connect($email);
        if($unClient!==null){
            if(!password_verify($mdp,$unClient['mdp'])){
              $form['valide'] = false;
              $form['message'] = 'Login ou mot de passe incorrect';
            }  
            else{
                $_SESSION['login'] = $email;     
                $_SESSION['role'] = $unClient['idRole'];
                $_SESSION['pseudo'] = $unClient['pseudo'];
                header("Location:index.php");
            } 
        }
        else{
           $form['valide'] = false;
           $form['message'] = 'Login ou mot de passe incorrect';
        }
    }
    echo $twig->render('connexion.html.twig', array('form'=>$form));
}

function actionDeconnexion($twig){
    session_unset();
    session_destroy();
    header("Location:index.php");
}

function actionInscription($twig,$db){
    $form = array(); 
    $form['valide'] = false;
    if(isset($_POST['btInscrire'])){
        $email = $_POST['email'];
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];
        $mdp2 = $_POST['mdp2'];
        $idRole = $_POST['role'];
        if ($mdp!=$mdp2){
            $form['valide'] = false;  
            $form['message'] = 'Les mots de passe sont différents';
        }
        else{
            $client = new Client($db);
            $exec = $client->insert($email, password_hash($mdp,PASSWORD_DEFAULT), $pseudo, $idRole);
            if(!$exec){
                $form['valide'] = false;  
                $form['message'] = 'Inscription non valide'; 
            }
            else{
                $form['valide'] = true;
                $form['message'] = "Inscription réussie !";
            }
        }
    }
    echo $twig->render('inscription.html.twig', array('form'=>$form));
}
?>