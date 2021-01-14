<?php 
    session_start();
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if(isset($_POST['commentaires_post'])){
            $text = (String) (trim($text));
            if(empty($text)) {
                $valid = false;
                $er_commentaire = "Merci d'écrire un commentaire avant de valider";

            }
            if($valid){
                $requete = $bdd->prepare('INSERT INTO commentaires(id_user, username, id_acteur, messages, date_creation) VALUES (?, ?, ?, ?, NOW');
                $requete->execute(array($_SESSION['id_user'],$_SESSION['prenom'], $_GET['id_acteur'], $text));
                //header('Location:acteur_page.php?id_acteur=1');
                header('Location:acteur_page.php?id_acteur=' . $_GET['id_acteur']);
                exit;
            }
        }
    }

  
?>