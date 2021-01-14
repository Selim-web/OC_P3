<?php
    session_start();
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root');

    // S'il y a une session alors on ne retourne plus sur cette page  
    if (!isset($_SESSION['id_user'])){
        header('Location: connexion.php');
        exit;
    }

    // Requête pour récuperer les infos de l'utilisateur 
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
    $req->execute(array($_SESSION['id_user']));
    $req_donnees = $req->fetch();

    $nom = $req_donnees['nom'];
    $prenom = $req_donnees['prenom'];
    $username = $req_donnees['username'];
    $password = $req_donnees['password'];
    $question = $req_donnees['question'];
    $reponse = $req_donnees['reponse'];
    
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if (isset($_POST['nouveau_mdp'])){

            $reponse = htmlspecialchars(trim($reponse));
          
           

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
                header('Location:accueil.php');

            }

        }
    }        
?>        


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> GBAF </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img id="logo" src=img/logo.png alt="">
    </header>

    <main id="corps">
        <img src="img/login.png" alt="">
        <form method="post">
            <div class="champs">
                <label> Nom :</label>
                <input type="text" name="nom" value="<?php echo $nom ?>"/>
            </div>
            <div class="champs">
                <label> Prenom :</label>
                <input type="text" name="prenom" value="<?php echo $prenom ?>"/>
            </div>
            <div class="champs">
                <label> Nom d'utilisateur :</label>
                <input type="text" name="username" value="<?php echo $username ?>"/>
            </div>
            <div class="champs">
                <label>Mot de passe :</label>
                <input type="password" name="password" value="<?php echo $password ?>"/>
            </div>
            <div class="champs">
                <label>Question secrète :</label>
                <select id="question" name="question">
                    <option value="Quel est le nom de votre ville natal ?">Quel est le nom de votre ville natal ?</option>
                    <option value="Quelle est la marque de votre première voiture ?">Quelle est la marque de votre première voiture ?</option>
                    <option value="Quel est le nom de jeune fille de votre mère ?">Quel est le nom de jeune fille de votre mère ?</option>
                    <option value="Quel est le nom de votre ami d'enfance ?">Quel est le nom de votre ami d'enfance ?</option>
                </select>
                <input type="text" name="question" value="<?php echo $question ?>"/>
            </div>
            <div class="champs">
                <label> Réponse :</label>
                <input type="text" name="reponse" placeholder="<?php if($er_reponse) { echo $er_reponse; } else { echo "Entrer votre reponse"; } ?>"/>
            </div>
            <input name="parametre_compte" type="submit" value="Valider">
        </form>
    </main>

    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
</footer>
</body>
</html>