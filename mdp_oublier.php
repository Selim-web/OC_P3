<?php
    session_start();
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root');

  // S'il y a une session alors on ne retourne plus sur cette page  
    if (isset($_SESSION['id_user'])){
        header('Location: accueil.php');
        exit;
    }
 
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;
 
        if (isset($_POST['changement_mdp'])){
            $username = htmlspecialchars(trim($username));
 
            if(empty($username)){ // Vérification username 
                $valid = false;
                $er_username = "Merci d'entrer votre username";
            }

            // Requête pour savoir si le username existe déjà 
            $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = ?');
            $req->execute(array($username));
            $req_verif = $req->fetch();
            
            if (!$req_verif) {
                $er_verif = "Le nom d'utilisateur est incorrecte";
            }

            else {
                header('Location:mdp_oublier_modification.php?id_user='. $req_verif['id_user']);
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
</head>
<body>
    <header>
        <img id="logo" src=img/logo.png alt="">
    </header>

    <main id="corps">
        <img src="img/mdp_oublie.png" alt="">
        <form method="post">
            <div class="champs">
                <label> Nom d'utilisateur :</label>
                <input type="text" name="username" placeholder="<?php if(isset($er_verif)) { echo $er_verif; } else { echo 'Entrez-votre nom d\'utilisateur'; } ?>"/>
            </div>
            <input name="changement_mdp" type="submit" value="Valider">
        </form>
    </main>

    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
</footer>
</body>
</html>