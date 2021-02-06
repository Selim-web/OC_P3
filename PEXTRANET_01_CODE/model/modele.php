<?php

// Ajouter Variable globale pour la bdd 

// Ajouter fonction connexion 

// Ajouter fonction inscription 

// Ajouter fonction Mdp oublier 

// Ajouter fonction deconnexion 

// Ajouter fonction parametre du compte avec modif 

function bddConnect()
{
    try
    {
        $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root');
        return $bdd;
    }
    catch (Exeception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

}

function getActeur()
{
   
    $bdd = bddConnect();

    $reponse = $bdd->query('SELECT * FROM acteur');

    return $reponse;
}

function getActeurDetail($id_acteur)
{
    $bdd = bddConnect();

    $req_acteur = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $req_acteur->execute(array($id_acteur));
    $acteur = $req_acteur->fetch();

    return $acteur;
}

function getCommentaire($id_acteur)
{
    $bdd = bddConnect();

    $req_commentaire = $bdd->prepare('SELECT * FROM commentaires WHERE id_acteur = ?');
    $req_commentaire->execute(array($id_acteur));
    
    return $req_commentaire;
}

function getNbrCommentaireByUser($id_user, $id_acteur)
{
    $bdd = bddConnect();

    $check_commentaire = $bdd->prepare('SELECT * FROM commentaires WHERE id_user = ? AND id_acteur = ?');
    $check_commentaire->execute(array($id_user, $id_acteur));

    return $check_commentaire->rowCount();
}

function getNbrCommentaireByActeur($id_acteur)
{
    $bdd = bddConnect();

    $req = $bdd->prepare('SELECT COUNT(commentaires) AS commentaires_total FROM commentaires WHERE id_acteur = ?');
    $req->execute(array($id_acteur));
    $nbr_commentaire = $req->fetch();

    return $nbr_commentaire;
}

function addCommentaire($id_user,$id_acteur,$username,$text)
{
    $bdd = bddConnect();

    $requete = $bdd->prepare('INSERT INTO commentaires(id_user, id_acteur, username, commentaires) VALUES (?, ?, ?, ?)');
    $new_commentaire = $requete->execute(array($id_user,$id_acteur,$username,$text));

    return $new_commentaire;
}

function getNbrLikeByActeur ($id_acteur)
{
    $bdd = bddConnect();
    // finir la fonction

}


?>