<?php
require_once('model/Manager.php');

class CommentManager extends Manager
{
    public function getCommentaire($id_acteur)
    {
        $bdd = $this->bddConnect();

        $req_commentaire = $bdd->prepare('SELECT * FROM commentaires WHERE id_acteur = ?');
        $req_commentaire->execute(array($id_acteur));
        
        return $req_commentaire;
    }

    public function getNbrCommentaireByUser($id_user, $id_acteur)
    {
        $bdd = $this->bddConnect();

        $check_commentaire = $bdd->prepare('SELECT * FROM commentaires WHERE id_user = ? AND id_acteur = ?');
        $check_commentaire->execute(array($id_user, $id_acteur));

        return $check_commentaire->rowCount();
    }

    public function getNbrCommentaireByActeur($id_acteur)
    {
        $bdd = $this->bddConnect();

        $req = $bdd->prepare('SELECT COUNT(commentaires) AS commentaires_total FROM commentaires WHERE id_acteur = ?');
        $req->execute(array($id_acteur));
        $nbr_commentaire = $req->fetch();

        return $nbr_commentaire;
    }

    public function addCommentaire($id_user,$id_acteur,$username,$text)
    {
        $bdd = $this->bddConnect();

        $requete = $bdd->prepare('INSERT INTO commentaires(id_user, id_acteur, username, commentaires) VALUES (?, ?, ?, ?)');
        $new_commentaire = $requete->execute(array($id_user,$id_acteur,$username,$text));

        return $new_commentaire;
    }
}