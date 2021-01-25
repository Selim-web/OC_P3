<?php 
    session_start();
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-'); 

    if (!isset($_SESSION['id_user'])){
        header('Location: connexion.php');
        exit;
    }
    // Requête pour compter le nombre de like par acteur 
    $likes = $bdd->prepare('SELECT * FROM likes WHERE id_acteur = ?');
    $likes->execute(array($_GET['id_acteur']));
    $likes = $likes->rowCount();

    // Requête pour compter le nombre de dislike par acteur 
    $dislikes = $bdd->prepare('SELECT * FROM dislikes WHERE id_acteur = ?');
    $dislikes->execute(array($_GET['id_acteur']));
    $dislikes = $dislikes->rowCount();

    // Requête pour checker le nombre de commentaire de l'utilisateur
    $check_commentaire = $bdd->prepare('SELECT * FROM commentaires WHERE id_user = ? AND id_acteur = ?');
    $check_commentaire->execute(array($_SESSION['id_user'], $_GET['id_acteur']));

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if(isset($_POST['commentaires_post'])){
            $text = (String) (trim($text));
            if(empty($text)) {
                $valid = false;
                $er_commentaire = "Merci d'écrire un commentaire avant de valider";
          
            }

            if ($check_commentaire->rowCount() == 1) {
                $valid = false;
                $er_commentaire = "Vous avez déjà posté un commentaire à propos de cet acteur";
            }

            if($valid){

                // On insere le commentaire
                $requete = $bdd->prepare('INSERT INTO commentaires(id_user, id_acteur, commentaires) VALUES (?, ?, ?)');
                $requete->execute(array($_SESSION['id_user'], $_GET['id_acteur'], $text));
                
                header('Location: acteur_page.php?id_acteur=' . $_GET['id_acteur']);
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
    <main id="main">
        <?php
        $req = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
        $req->execute(array($_GET['id_acteur']));
        $donnees = $req->fetch();
        ?>
        <div id="acteur_detail">
            <?php echo '<img src= "'. $donnees['logo'] . '"/>'; ?> 
            <h2><br><?php echo $donnees['acteur']; ?></h2>
            <a href="<?php echo $donnees['acteur'] . '.fr' ?>"><br><?php echo $donnees['acteur']; ?></a>
            <p><br> <?php echo $donnees['descriptions']; ?> </p>
        </div>
        <?php
        $req = $bdd->prepare('SELECT COUNT(commentaires) AS commentaires_total FROM commentaires WHERE id_acteur = ?');
        $req->execute(array($_GET['id_acteur']));
        $commentaire = $req->fetch();
        ?>
        <div id="bloc_com">
           <div class="header_bloc_com">
                <h3><?php echo $commentaire['commentaires_total']; ?> COMMENTAIRES</h3>
                <div id="bloc_reaction">
                    <a id="button_commentaire" href="#nouveau_com">Nouveau Commentaire</a>
                    <p><?= $likes ?></p>
                    <a href="like_dislike.php?type=1&id_acteur=<?php echo $_GET['id_acteur']; ?>">
                        <img src="img/like.png" alt="">
                    </a>
                    <p><?= $dislikes ?></p>
                    <a href="like_dislike.php?type=2&id_acteur=<?php echo $_GET['id_acteur']; ?>">
                        <img src="img/dislike.png" alt="">
                    </a>
                </div>
            </div>
            <?php
            // Requête pour afficher les derniers commentaires en fonction de l'acteur
            $req = $bdd->prepare('SELECT * FROM commentaires WHERE id_acteur = ?');
            $req->execute(array($_GET['id_acteur']));
            while($commentaire = $req->fetch())
            {
                $req_user= $bdd->prepare('SELECT username FROM utilisateurs WHERE id_user = ?');
                $req_user->execute(array($commentaire['id_user']));
                $user=$req_user->fetch();
            ?>
                <div id="dernier_com">
                    <article>
                        <div class="header_dernier_com">
                            <h4><?php echo $user['username']; ?> </h4>
                            <label><?php echo $commentaire['date_creation'];?></label>
                            <p><?php echo $commentaire ['commentaires']; ?></p>
                        </div>
                    </article>
            <?php
            }
            $req->closeCursor();
            ?>
                <h3>AJOUTER UN COMMENTAIRE</h3>
                <form method="post">
                    <textarea name="text" placeholder="<?php if(isset($er_commentaire)) { echo $er_commentaire; } else { echo 'Votre commentaire...'; } ?>"></textarea>
                    <br>
                    <input name="commentaires_post" type="submit" value="ENVOYER">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <a href="mentions_legales.php">Mentions Légales</a>
    </footer>
</body>
</html>