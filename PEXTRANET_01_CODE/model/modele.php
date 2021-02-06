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
    
    $likes = $bdd->prepare('SELECT * FROM likes WHERE id_acteur = ?');
    $likes->execute(array($_GET['id_acteur']));
    $likes = $likes->rowCount();

    return $likes;

}

function getNbrDislikeByActeur ($id_acteur)
{
    $bdd = bddConnect();

    $dislikes = $bdd->prepare('SELECT * FROM dislikes WHERE id_acteur = ?');
    $dislikes->execute(array($_GET['id_acteur']));
    $dislikes = $dislikes->rowCount();

    return $dislikes;
}

function check_like($id_acteur, $id_user) {
    
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 
    $check_like = $bdd->prepare('SELECT * FROM likes WHERE id_acteur = ? AND id_user = ?');
    $check_like->execute(array($id_acteur,$id_user));

    return $check_like->rowCount();
}

function check_dislike($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    $check_dislike = $bdd->prepare('SELECT * FROM dislikes WHERE id_acteur = ? AND id_user = ?');
    $check_dislike->execute(array($id_acteur,$id_user));

    return $check_dislike->rowCount();
}

function insert_like($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    $like = $bdd->prepare('INSERT INTO likes (id_acteur,id_user) VALUE (?,?)');
    $like->execute(array($id_acteur,$id_user));    
}

function insert_dislike($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    $dislike = $bdd->prepare('INSERT INTO dislikes (id_acteur,id_user) VALUE (?,?)');
    $dislike->execute(array($id_acteur,$id_user));    
}

function delete_like($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    $delete_like = $bdd->prepare('DELETE FROM likes WHERE id_acteur = ? AND id_user = ?');
    $delete_like->execute(array($id_acteur,$id_user));
}

function delete_dislike($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    $delete_dislike = $bdd->prepare('DELETE FROM dislikes WHERE id_acteur = ? AND id_user = ?');
    $delete_dislike->execute(array($id_acteur,$id_user));
}
?>