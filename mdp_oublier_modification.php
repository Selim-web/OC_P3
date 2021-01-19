<?php
    session_start();
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root');

    // S'il y a une session alors on ne retourne plus sur cette page  
    if (isset($_SESSION['id_user'])){
        header('Location: accueil.php');
        exit;
    }

    // Requête pour récuperer les infos de l'utilisateur 
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
    $req->execute(array($_GET['id_user']));
    $req_donnees = $req->fetch();

    $username = $req_donnees['username'];
    $question = $req_donnees['question'];
    
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if (isset($_POST['nouveau_mdp'])){

            $reponse = htmlspecialchars(trim($reponse));
            $password = trim($password);
            $conf_password = trim($conf_password);

            if($reponse != $req_donnees['reponse']) {
            $valid = false;
            $er_reponse = "Ce n'est pas la bonne réponse";
            }

            // Vérification du mot de passe
            if(empty($password)) {
                $valid = false;
                $er_password = "Le mot de passe ne peut pas être vide";
 
            }
            elseif($password != $conf_password){
                $valid = false;
                $er_password = "La confirmation du mot de passe ne correspond pas";
            }

            if($valid) {
                $password_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // On update le password de l'utilisateur 
                $new_mdp = $bdd->prepare('UPDATE utilisateurs SET password = ? WHERE id_user = ?');
                $new_mdp->execute(array($password_hache, $_GET['id_user']));
                header('Location:connexion.php');

            }

        }
    }        
?>        


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> GBAF </title>
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
                <input type="text" name="username" value="<?php echo $username ?>"/>
            </div>
            <div class="champs">
                <label>Question secrète :</label>
                <input type="text" name="question" value="<?php echo $question ?>"/>
            </div>
            <div class="champs">
                <label> Réponse :</label>
                <input type="text" name="reponse" placeholder="<?php if(isset($er_reponse)) { echo $er_reponse; } else { echo 'Entrer votre reponse'; } ?>"/>
            </div>
            <div class="champs">
                <label>Mot de passe :</label>
                <input type="password" name="password" placeholder="Entre votre mot de passe"/>
            </div>
            <div class="champs">
                <label>Confirmation mot de passe :</label>
                <input type="password" name="conf_password" placeholder="Entre votre mot de passe"/>
            </div>
            <input name="nouveau_mdp" type="submit" value="Valider">
        </form>
    </main>

    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
</footer>
</body>
</html>