 <?php 

require_once('model/Manager.php');

class UserManager extends Manager
{
    public function InsertUser($nom,$prenom,$username,$password_hache, $question, $reponse)
    {
        $bdd = $this->bddConnect();

        $req = $bdd->prepare('INSERT INTO utilisateurs (nom, prenom, username, password, question, reponse) VALUES (?, ?, ?, ?, ?, ?)'); 
        $req->execute(array($nom,$prenom,$username,$password_hache, $question, $reponse)); 
    }

    public function UpdateUser($nom, $prenom, $username, $question, $reponse, $id_user) 
    {
        $bdd = $this->bddConnect();

        $nouveau_para = $bdd->prepare('UPDATE utilisateurs SET nom = ?, prenom = ?, username = ?, question = ?, reponse = ?  WHERE id_user = ?');
        $nouveau_para->execute(array($nom, $prenom, $username, $question, $reponse, $id_user));
        
    }

    public function UpdatePassword($password,$username)
    {
        $bdd = $this->bddConnect();

        $new_mdp = $bdd->prepare('UPDATE utilisateurs SET password = ? WHERE username = ?');
        $new_mdp->execute(array($password,$username));
        
    }


    public function getUser($username) {

        $bdd = $this->bddConnect();

        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = ?');
        $req->execute(array($username));
        $req_verif = $req->fetch();

        return $req_verif;
    }

    public function getUserById($id_user) {

        $bdd = $this->bddConnect();

        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
        $req->execute(array($id_user));
        $req_donnees = $req->fetch();

        return $req_donnees;
    }
}