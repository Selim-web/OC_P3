<?php 

require_once('model/Manager.php');

class VoteManager extends Manager
{
    public function getNbrLikeByActeur ($id_acteur)
    {
        $bdd = $this->bddConnect();
        
        $likes = $bdd->prepare('SELECT * FROM likes WHERE id_acteur = ?');
        $likes->execute(array($_GET['id_acteur']));
        $likes = $likes->rowCount();

        return $likes;

    }

    public function getNbrDislikeByActeur ($id_acteur)
    {
        $bdd = $this->bddConnect();

        $dislikes = $bdd->prepare('SELECT * FROM dislikes WHERE id_acteur = ?');
        $dislikes->execute(array($_GET['id_acteur']));
        $dislikes = $dislikes->rowCount();

        return $dislikes;
    }

    public function check_like($id_acteur, $id_user) {
        
        $bdd = $this->bddConnect();

        $check_like = $bdd->prepare('SELECT * FROM likes WHERE id_acteur = ? AND id_user = ?');
        $check_like->execute(array($id_acteur,$id_user));

        return $check_like->rowCount();
    }

    public function check_dislike($id_acteur, $id_user) {
        $bdd = $this->bddConnect();

        $check_dislike = $bdd->prepare('SELECT * FROM dislikes WHERE id_acteur = ? AND id_user = ?');
        $check_dislike->execute(array($id_acteur,$id_user));

        return $check_dislike->rowCount();
    }

    public function insert_like($id_acteur, $id_user) {
        $bdd = $this->bddConnect();

        $like = $bdd->prepare('INSERT INTO likes (id_acteur,id_user) VALUE (?,?)');
        $like->execute(array($id_acteur,$id_user));    
    }

    public function insert_dislike($id_acteur, $id_user) {
        $bdd = $this->bddConnect();

        $dislike = $bdd->prepare('INSERT INTO dislikes (id_acteur,id_user) VALUE (?,?)');
        $dislike->execute(array($id_acteur,$id_user));    
    }

    public function delete_like($id_acteur, $id_user) {
        $bdd = $this->bddConnect();

        $delete_like = $bdd->prepare('DELETE FROM likes WHERE id_acteur = ? AND id_user = ?');
        $delete_like->execute(array($id_acteur,$id_user));
    }

    public function delete_dislike($id_acteur, $id_user) {
        $bdd = $this->bddConnect();

        $delete_dislike = $bdd->prepare('DELETE FROM dislikes WHERE id_acteur = ? AND id_user = ?');
        $delete_dislike->execute(array($id_acteur,$id_user));
    }
}