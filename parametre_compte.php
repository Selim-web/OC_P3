<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-');

    // S'il n'y a pas de session alors on retourne sur la page de connexion 
    if (!isset($_SESSION['id_user'])){
        header('Location: connexion.php');
        exit;
    }

    // Requête pour récuperer les infos de l'utilisateur 
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
    $req->execute(array($_SESSION['id_user']));
    $req_donnees = $req->fetch();

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if (isset($_POST['parametre_compte'])){

            $nom  = htmlspecialchars(trim($nom)); // On récupère le nom
            $prenom = htmlspecialchars(trim($prenom)); // on récupère le prénom
            $username = htmlspecialchars(trim($username)); // On récupère le nom d'utilisateur
            $question = htmlspecialchars(trim($question)); // On récupère la question 
            $reponse = htmlspecialchars(trim($reponse)); // On récupère la reponse 
            
            if($username == $_SESSION['username']) {
                $valid = true;
            }

            else {

                // Requete pour verifier si le nom d'utilisateur entré est disponible en BDD
                $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = ?');
                $req->execute(array($username));
                $req_username = $req->fetch();

                if($req_username['username'] != "") {
                    $valid = false;
                    $er_username = "Ce nom d'utilisateur existe déjà";
                
                }
            }
            
            if($valid) {
                
                // On update l'utilisateur 
                $nouveau_para = $bdd->prepare('UPDATE utilisateurs SET nom = ?, prenom = ?, username = ?, question = ?, reponse = ?  WHERE id_user = ?');
                $nouveau_para->execute(array($nom, $prenom, $username, $question, $reponse, $_SESSION['id_user']));
                $_SESSION['prenom'] = $prenom;
                $_SESSION['nom'] = $nom;
                $_SESSION['username'] = $username;
                header('Location:index.php');

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
        <a href="index.php">
            <img id="logo" src=img/logo.png alt="">
        </a>
        <nav>
            <a href="parametre_compte.php">
                <img class="icon" src="img/user.png" alt="">
                <p><?php echo $_SESSION['nom'] .' '. $_SESSION['prenom']; ?></p>
            </a>
            <a href="deconnexion.php">
               <img class="icon" src="img/logout.png" alt=""> 
            </a>
        </nav>
    </header>
    <main id="corps">
        <img src="img/login.png" alt="">
        <h2>MON COMPTE</h2>
        <form method="post">
            <div class="champs">
                <label> Nom :</label>
                <input type="text" name="nom" value="<?php echo $req_donnees['nom'] ?>"/>
            </div>
            <div class="champs">
                <label> Prenom :</label>
                <input type="text" name="prenom" value="<?php echo $req_donnees['prenom'] ?>"/>
            </div>
            <div class="champs">
                <label> Nom d'utilisateur :</label>
                <input type="text" name="username" value="<?php echo $req_donnees['username'] ?>"/>
            </div>
            <div class="champs">
                <label>Question secrète :</label>
                <select id="question" name="question">
                    <option value="<?php echo $req_donnees['question'] ?>"> Votre question :  <?php echo $req_donnees['question'] ?> </option>
                    <option value="Quel est le nom de votre ville natal ?">Quel est le nom de votre ville natal ?</option>
                    <option value="Quelle est la marque de votre première voiture ?">Quelle est la marque de votre première voiture ?</option>
                    <option value="Quel est le nom de jeune fille de votre mère ?">Quel est le nom de jeune fille de votre mère ?</option>
                    <option value="Quel est le nom de votre ami d'enfance ?">Quel est le nom de votre ami d'enfance ?</option>
                </select>
            </div>
            <div class="champs">
                <label> Réponse :</label>
                <input type="text" name="reponse" value="<?php echo $req_donnees['reponse'] ?>"/>
            </div>
            <p><?php if (isset($er_username)) { echo $er_username; }?></p>
            <input name="parametre_compte" type="submit" value="Valider">
        </form>
    </main>

    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>