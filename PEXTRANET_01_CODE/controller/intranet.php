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
    
    $likes = getNbrLikeByActeur($_GET['id_acteur']);
    $dislikes = getNbrDislikeByActeur($_GET['id_acteur']);
    
    require('view/ActeurDetail.php');

}

function NbrCommentaireByUser($id_user, $id_acteur)
{
    require('model/modele.php');

    $nbr_commentaire_by_user = getNbrCommentaireByUser($id_user, $id_acteur);

    require('view/ActeurDetail.php');
}

function PostCommentaire($id_user,$id_acteur,$username,$text) 
{
    require('model/modele.php');

    $new_commentaire = addCommentaire($id_user,$id_acteur,$username,$text);

    header('Location: index.php?action=PageActeur&id_acteur='. $id_acteur);
    
    require('view/ActeurDetail.php');

}

function toggle_like($id_acteur,$id_user) {

    require('model/modele.php');

    $checklike = check_like($id_acteur, $id_user);

    delete_dislike($id_acteur,$id_user);
    if($checklike == 1) {
        delete_like($id_acteur,$id_user);
    }
    else {
        insert_like($id_acteur,$id_user);
    }
    header('Location:index.php?action=PageActeur&id_acteur=' . $id_acteur);

    require('view/ActeurDetail.php');
}

function toggle_dislike($id_acteur,$id_user) {

    require('model/modele.php');

    $checkdislike = check_dislike($id_acteur, $id_user);

    delete_like($id_acteur,$id_user);
    if($checkdislike == 1) {
        delete_dislike($id_acteur,$id_user);
    }
    else {
        insert_dislike($id_acteur,$id_user);
    }
    
    header('Location:index.php?action=PageActeur&id_acteur=' . $id_acteur);

    require('view/ActeurDetail.php');
}




