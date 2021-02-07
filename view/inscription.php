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
        <img src=public/img/login.png alt="">
        <form method="post" novalidate>
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
                <input type="text" name="username" placeholder="<?php if(isset($er_username)) { echo $er_username; } else { echo 'Entrer votre nom d utilisateur';}?> "/>
            </div>
            <div class="champs">
                <label>Mot de passe :</label>
                <input type="password" name="password" placeholder="<?php if(isset($er_password)) { echo $er_password; } else { echo 'Entrer votre mot de passe'; }?>"/>
            </div>
            <div class="champs">
                <label>Confirmation mot de passe :</label>
                <input type="password" name="conf_password" placeholder="<?php if(isset($er_password)) { echo $er_password; } else { echo 'Entrer de nouveau votre mot de passe';} ?>"/>
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