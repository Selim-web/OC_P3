<?php
    session_start();

    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root');
 
    // S'il y a une session alors on ne retourne plus sur cette page
    if (isset($_SESSION['id_user'])){
        header('Location: accueil.php'); 
        exit;
    }
 
    // Si la variable "$_POST" contient des informations alors on les traitres
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;
 
        // On se place sur le bon formulaire grâce au "name" de la balise "input"
        if (isset($_POST['inscription'])){
            $nom  = htmlspecialchars(trim($nom)); // On récupère le nom
            $prenom = htmlspecialchars(trim($prenom)); // on récupère le prénom
            $username = htmlspecialchars(trim($username)); // On récupère le mail
            $password = trim($password); //  On récupère le mot de passe
            $conf_password = trim($password);  //  On récupère la confirmation du mot de passe
            $question = htmlspecialchars(trim($question)); // On récupère la question 
            $reponse = htmlspecialchars(trim($reponse)); // On récupère la reponse 
 
            
            if(empty($username)) {
                $valid = false;
                $er_username = ("Le nom d'utilisateur n'est pas valide");
            }
            
            else{
                // On vérifit que le nom d'utilisateur est disponible
                $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = ?');
                $req->execute(array($_POST['username']));
                $req_username = $req->fetch();
 
                if ($req_username['username'] <> ""){
                    $valid = false;
                    $er_username = "Ce nom d'utilisateur existe déjà";
                }
            }

            // Vérification du mot de passe
            if(empty($password)) {
                $valid = false;
                $er_password = "Le mot de passe ne peut pas être vide";
 
            }elseif($password != $conf_password){
                $valid = false;
                $er_password = "La confirmation du mot de passe ne correspond pas";
            }
 
            // Si toutes les conditions sont remplies alors on fait le traitement
            if($valid){
 
                $password_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
                // On insert nos données dans la table utilisateur
                $req = $bdd->prepare('INSERT INTO utilisateurs (nom, prenom, username, password, question, reponse) VALUES 
                    (?, ?, ?, ?, ?, ?)'); 
                $req->execute(array($nom,$prenom,$username,$password_hache, $question, $reponse)); 
                
                header('Location: accueil.php');
                exit;
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> GBAF</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img id="logo" src=img/logo.png alt="">
    </header>

    <main id="corps">
        <img src=img/login.png alt="">
        <form method="post">
            <div class="champs">
                <label> Nom :</label>
                <input type="text" name="nom" placeholder="Entrer votre nom"/>
            </div>
            <div class="champs">
                <label> Prenom :</label>
                <input type="text" name="prenom" placeholder="Entrer votre prénom"/>
            </div>
            <div class="champs">
                <label> Nom d'utilisateur :</label>
                <input type="text" name="username" placeholder="Entrer votre nom d'utilisateur <?php if(isset($er_username)) { echo $er_username; }?>"/>
            </div>
            <div class="champs">
                <label>Mot de passe :</label>
                <input type="password" name="password" placeholder="Entre votre mot de passe<?php if(isset($er_password)) { echo $er_password; }?>"/>
            </div>
            <div class="champs">
                <label>Confirmation mot de passe :</label>
                <input type="password" name="conf_password" placeholder="Entre votre mot de passe<?php if(isset($er_password)) { echo $er_password; }?>"/>
            </div>
            <div class="champs">
                <label for="question">Question secrète : </label>
                <select id="question" name="question">
                    <option value="Choissisez une question secrète" selected="selected" disabled="">Choissisez une question secrète</option>
                    <option value="Quel est le nom de votre ville natal ?">Quel est le nom de votre ville natal ?</option>
                    <option value="Quelle est la marque de votre première voiture ?">Quelle est la marque de votre première voiture ?</option>
                    <option value="Quel est le nom de jeune fille de votre mère ?">Quel est le nom de jeune fille de votre mère ?</option>
                    <option value="Quel est le nom de votre ami d'enfance ?">Quel est le nom de votre ami d'enfance ?</option>
                </select>
            </div>
            <div class="champs">
                <label> Réponse :</label>
                <input type="text" name="reponse" placeholder="Entrer votre réponse"/>
            </div>
            <input type="submit" name="inscription" value="Inscription">
        </form>
    </main>

    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>