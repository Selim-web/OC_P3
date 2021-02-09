<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title> GBAF</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <img id="logo" src=public/img/logo.png alt="">
    </header>
    <main id="corps">
        <img src="public/img/mdp_oublie.png" alt="">
        <form method="post">
            <div class="champs">
                <label> Nom d'utilisateur :</label>
                <input type="text" name="username" value="<?php echo $req_verif['username'] ?>"/>
            </div>
            <div class="champs">
                <label>Question secrète :</label>
                <input type="text" name="question" value="<?php echo $req_verif['question'] ?>"/>
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
                <input type="password" name="conf_password" placeholder="<?php if(isset($er_password)) { echo $er_password; } else { echo 'Entrer votre mot de passe'; } ?>"/>
            </div>
            <input name="nouveau_mdp" type="submit" value="Valider">
        </form>
    </main>
    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
</footer>
</body>
</html>