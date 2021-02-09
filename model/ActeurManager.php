<?php

require_once('model/Manager.php');

class ActeurManager  extends Manager
{
    public function getActeur()
    {
    
        $bdd = $this->bddConnect();

        $reponse = $bdd->query('SELECT * FROM acteur');

        return $reponse;
    }

    public function getActeurDetail($id_acteur)
    {
        $bdd = $this->bddConnect();

        $req_acteur = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
        $req_acteur->execute(array($id_acteur));
        $acteur = $req_acteur->fetch();

        return $acteur;
    }
}