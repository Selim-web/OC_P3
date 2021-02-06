<?php
session_start();

if (!isset($_SESSION['id_user'])){
    header('Location: connexion.php');
    exit;
}

// Ajouter Variable globale pour le modele 

// Ajouter fonction connexion 

// Ajouter fonction inscription 

// Ajouter fonction Mdp oublier 

// Ajouter fonction deconnexion 

// Ajouter fonction parametre du compte avec modif 



function PageHome()
{
    require('model/modele.php');

    $reponse = getActeur();

    require('view/accueil.php');
}

function ListActeurDetail()

{
    require('model/modele.php');

    $acteur = getActeurDetail($_GET['id_acteur']);
    $req_commentaire = getCommentaire($_GET['id_acteur']);
    $nbr_commentaire = getNbrCommentaireByActeur($_GET['id_acteur']);
    
    require('view/ActeurDetail.php');

}

function PostCommentaire($id_user,$id_acteur,$username,$text) 
{
    require('model/modele.php');

    if(empty($text)) 
    {
        $er_commentaire = "Merci d'écrire un commentaire avant de valider";
    }

    if(getNbrCommentaireByUser($id_user,$id_acteur) == 1)
    {
        $er_commentaire = "Vous avez déjà posté un commentaire à propos de cet acteur";
    }
    else {
        $new_commentaire = addCommentaire($id_user,$id_acteur,$username,$text);
    }
    header('Location: index.php?action=PageActeur&id_acteur='. $id_acteur);
    require('view/ActeurDetail.php');

}



