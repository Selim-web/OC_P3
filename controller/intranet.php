<?php

// Chargement des classes
require_once('model/ActeurManager.php');
require_once('model/VoteManager.php');
require_once('model/UserManager.php');
require_once('model/CommentManager.php');

function PageConnexion()
{
    include('view/connexion.php');
}

function Connexion($username, $password)
{
    $userManager = new UserManager();

    $username = htmlspecialchars(trim($username));
    $password = trim($password);
    $user = $userManager->getUser($username);
    $isPasswordCorrect = password_verify($password, $user['password']);

    if($isPasswordCorrect) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['username'] = $user['username'];

        header('Location: index.php?action=PageHome');
        exit; 
    }
    else {
        $er_verif = "Le nom d'utilisateur ou le mot de passe est incorrecte";
    }

    require('view/connexion.php');
}

function PageMdpOublier()
{
    include('view/mdp_oublier.php');
}

function MdpOublier($username)
{
    $userManager = new UserManager();

    $username = htmlspecialchars(trim($username));
    $user = $userManager->getUser($username);


    if($user){
        $user_verify = $user['username'];
        header('Location: index.php?action=ModificationMdp&username='. $user_verify);
       
    }
    else {
        $er_verif = "Le nom d'utilisateur est incorrect"; 
       
    }

    require('view/mdp_oublier.php');
}

function PageMdpModification($username)
{
    $req_manager = new UserManager();

    $req_verif = $req_manager->getUser($username);

    require('view/mdp_oublier_modification.php');

}

function MdpOublierModification($reponse, $password, $conf_password, $username)
{
    $userManager = new UserManager();
    $updateManager = new UserManager();

    $reponse = htmlspecialchars(trim($reponse));
    $password = trim($password);
    $conf_password = trim($conf_password);
    $user = $userManager->getUser($username);
    $valid = true;

    if($reponse != $user['reponse']) {
        $valid = false;
        $er_reponse = "Ce n'est pas la bonne réponse";
    }
    if(empty($password)) {
        $valid = false;
        $er_password = "Le mot de passe ne peut pas être vide";

    }
    elseif($password != $conf_password){
        $valid = false;
        $er_password = "La confirmation du mot de passe ne correspond pas";
    }
    if($valid) {
        $password_hache = password_hash($password, PASSWORD_DEFAULT);
        $updateManager->UpdatePassword($password_hache,$username);
        header('Location: index.php');
        exit;
        
    }
    require('view/mdp_oublier_modification.php');
}

function Deconnexion()
{
    session_start();
    session_destroy();
    header('Location: index.php');
    exit;
}

function PageInscription()
{
    include('view/inscription.php');
}

function Inscription($nom, $prenom, $username, $password, $conf_password, $question, $reponse)
{
    $userManager = new UserManager();
    $insertManager = new UserManager();

    $nom  = htmlspecialchars(trim($nom));
    $prenom = htmlspecialchars(trim($prenom));
    $username = htmlspecialchars(trim($username)); 
    $password = trim($password); 
    $conf_password = trim($conf_password);
    $question = htmlspecialchars(trim($question));
    $reponse = htmlspecialchars(trim($reponse));

    $valid = true;    

    if($userManager->getUser($username) <> "") {
        $valid = false;
        $er_username = "Ce nom d'utilisateur existe déjà";
    }
    if(empty($password)) {
        $valid = false;
        $er_password = "Le mot de passe ne peut pas être vide";
    }
    if($password != $conf_password){
        $valid = false;
        $er_password = "La confirmation du mot de passe ne correspond pas";
    }
    if($valid) {
        $password_hache = password_hash($password, PASSWORD_DEFAULT);
        $insertManager->InsertUser($nom,$prenom,$username,$password_hache, $question, $reponse);
        header('Location:index.php');
        exit;
    }
    require('view/inscription.php');
}

function PageParametre($id_user)
{
    $req_donneesManager = new UserManager();

    $req_donnees = $req_donneesManager->getUserById($id_user);

    require('view/parametre_compte.php');
}

function Parametre($nom, $prenom, $username, $question, $reponse, $id_user) 
{
    $userManager = new UserManager();
    $updateManager = new UserManager();

    $nom  = htmlspecialchars(trim($nom));
    $prenom = htmlspecialchars(trim($prenom));
    $usernamePost = htmlspecialchars(trim($username)); 
    $question = htmlspecialchars(trim($question));
    $reponse = htmlspecialchars(trim($reponse));

    $testUsername = $userManager->getUser($usernamePost);

    $valid = true;    
    if($usernamePost == $_SESSION['username']) {
        echo $_SESSION['username'];
        $valid = true;

    }
    else {
        if($testUsername['username'] != "") {
            $valid = false;
            $er_username = "Ce nom d'utilisateur existe déjà";
           // PageParametre($id_user);
        }
    }
    if($valid) {
        $updateManager->UpdateUser($nom,$prenom,$username, $question, $reponse, $id_user);
        $_SESSION['prenom'] = $prenom;
        $_SESSION['nom'] = $nom;
        $_SESSION['username'] = $username;
        header('Location:index.php');
        exit;
    }
    require('view/parametre_compte.php');
}


function PageHome()
{
    $reponseManager = new ActeurManager(); // Création de l'objet
    $reponse = $reponseManager->getActeur(); // Appel de la fonction de l'objet

    require('view/accueil.php');
}

function ListActeurDetail()

{
    $acteurManager = new ActeurManager();
    $req_Manager = new CommentManager();
    $nbr_Manager = new CommentManager();

    $likesManager = new VoteManager();
    $dislikesManager = new VoteManager();

    $acteur = $acteurManager->getActeurDetail($_GET['id_acteur']);
    $req_commentaire = $req_Manager->getCommentaire($_GET['id_acteur']);
    $nbr_commentaire = $nbr_Manager->getNbrCommentaireByActeur($_GET['id_acteur']);
    
    $likes = $likesManager->getNbrLikeByActeur($_GET['id_acteur']);
    $dislikes = $dislikesManager->getNbrDislikeByActeur($_GET['id_acteur']);
    
    require('view/ActeurDetail.php');

}

function PostCommentaire($id_user,$id_acteur,$username,$text) 
{
    $new_comManager = new CommentManager();

    $new_commentaire = $new_comManager->addCommentaire($id_user,$id_acteur,$username,$text);

    header('Location: index.php?action=PageActeur&id_acteur='. $id_acteur);
    
    require('view/ActeurDetail.php');

}

function NbrCommentaireByUser($id_user, $id_acteur)
{
    $nbr_comManager = new CommentManager();

    $nbr_commentaire_by_user = $nbr_comManager->getNbrCommentaireByUser($id_user, $id_acteur);

    require('view/ActeurDetail.php');
}

function toggle_like($id_acteur,$id_user) {

    $checklikeManager = new VoteManager();
    $deleteManager = new VoteManager();
    $insertManager = new VoteManager();

    $checklike = $checklikeManager->check_like($id_acteur, $id_user);

    $deleteManager->delete_dislike($id_acteur,$id_user);
    if($checklike == 1) {
        $deleteManager->delete_like($id_acteur,$id_user);
    }
    else {
        $insertManager->insert_like($id_acteur,$id_user);
    }
    header('Location:index.php?action=PageActeur&id_acteur='. $id_acteur);

    require('view/ActeurDetail.php');
}

function toggle_dislike($id_acteur,$id_user) {

    $checkdislikeManager = new VoteManager();
    $deleteManager = new VoteManager();
    $insertManager = new VoteManager();

    $checkdislike = $checkdislikeManager->check_dislike($id_acteur, $id_user);

    $deleteManager->delete_like($id_acteur,$id_user);
    if($checkdislike == 1) {
        $deleteManager->delete_dislike($id_acteur,$id_user);
    }
    else {
        $insertManager->insert_dislike($id_acteur,$id_user);
    }
    
    header('Location:index.php?action=PageActeur&id_acteur='. $id_acteur);

    require('view/ActeurDetail.php');
}




