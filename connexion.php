<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-');

  // S'il y a une session alors on ne retourne plus sur cette page  
    if (isset($_SESSION['id_user'])){
        header('Location: index.php');
        exit;
    }
 
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;
 
        if (isset($_POST['connexion'])){
            $username = htmlspecialchars(trim($username));
            $password = trim($password);
 
            if(empty($username)){ // Vérification username 
                $valid = false;
                $er_username = "Merci d'entrer votre username";
            }
 
            if(empty($password)){ // Vérification mot de passe 
                $valid = false;
                $er_password = "Merci d'entrer votre mot de passe";
            }
 
            // Requête pour savoir si le username existe déjà 
            $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = ?');
            $req->execute(array($username));
            $req_verif = $req->fetch();
            
            if (!$req_verif) {
                $er_verif = "Le nom d'utilisateur ou le mot de passe est incorrecte";
            }
            else {
                if(password_verify($password, $req_verif['password'])) {
                    $_SESSION['id_user'] = $req_verif['id_user'];
                    $_SESSION['nom'] = $req_verif['nom'];
                    $_SESSION['prenom'] = $req_verif['prenom'];
                    $_SESSION['username'] = $req_verif['username'];

                    header('Location: index.php');
                    exit;
                    
                }
                else {
                    $er_verif = "Le nom d'utilisateur ou le mot de passe est incorrecte";
                }
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> GBAF</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <img id="logo" src=img/logo.png alt="">
    </header>


    <main id="corps">
        <img src=img/login.png alt="">
        <form method="post">
            <div class="champs">
                <label>Nom d'utilisateur :</label>
                <input type="text" name="username" placeholder="<?php if(isset($er_username)) { echo $er_username; } else { echo 'Username'; } ?> "/>
            </div>
            <div class="champs">
                <label>Mot de passe :</label>
                <input type="password" name="password" placeholder="********"/>
            </div>
                <p><?php if(isset($er_verif)) { echo $er_verif; } ?></p>
                <a href="mdp_oublier.php">Mot de passe oublié</a>
                <br>
                <input type="submit" name="connexion" value="Connexion">
        </form>
        <a id="inscription" href="inscription.php">Inscripton</a>
    </main>

    <footer>
            <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>