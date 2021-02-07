<?php

// Ajouter Variable globale pour le modele 

function PageConnexion()
{
    include('view/connexion.php');
}

function Connexion($username, $password)
{
    require('model/modele.php');

    $username = htmlspecialchars(trim($username));
    $password = trim($password);
    $user = getUser($username);
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
    require('model/modele.php');

    $username = htmlspecialchars(trim($username));
    $user = getUser($username);


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
    require('model/modele.php');

    $req_verif = getUser($username);

    require('view/mdp_oublier_modification.php');

}

function MdpOublierModification($reponse, $password, $conf_password, $username)
{
    require('model/modele.php');

    $reponse = htmlspecialchars(trim($reponse));
    $password = trim($password);
    $conf_password = trim($conf_password);
    $user = getUser($username);
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
        UpdatePassword($password_hache,$username);
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
    require('model/modele.php');

    $nom  = htmlspecialchars(trim($nom));
    $prenom = htmlspecialchars(trim($prenom));
    $username = htmlspecialchars(trim($username)); 
    $password = trim($password); 
    $conf_password = trim($conf_password);
    $question = htmlspecialchars(trim($question));
    $reponse = htmlspecialchars(trim($reponse));

    $valid = true;    

    if(getUser($username) <> "") {
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
        InsertUser($nom,$prenom,$username,$password_hache, $question, $reponse);
        header('Location:index.php');
        exit;
    }
    require('view/inscription.php');
}

function PageParametre($id_user)
{
    require('model/modele.php');

    $req_donnees = getUserById($id_user);

    require('view/parametre_compte.php');
}

function Parametre($nom, $prenom, $username, $question, $reponse, $id_user) 
{
    require('model/modele.php');

    $nom  = htmlspecialchars(trim($nom));
    $prenom = htmlspecialchars(trim($prenom));
    $usernamePost = htmlspecialchars(trim($username)); 
    $question = htmlspecialchars(trim($question));
    $reponse = htmlspecialchars(trim($reponse));

    $testUsername = getUser($usernamePost);

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
        UpdateUser($nom,$prenom,$username, $question, $reponse, $id_user);
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

function PostCommentaire($id_user,$id_acteur,$username,$text) 
{
    require('model/modele.php');

    $new_commentaire = addCommentaire($id_user,$id_acteur,$username,$text);

    header('Location: index.php?action=PageActeur&id_acteur='. $id_acteur);
    
    require('view/ActeurDetail.php');

}

function NbrCommentaireByUser($id_user, $id_acteur)
{
    require('model/modele.php');

    $nbr_commentaire_by_user = getNbrCommentaireByUser($id_user, $id_acteur);

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




