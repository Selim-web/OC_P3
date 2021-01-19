<?php 
    session_start();
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if(isset($_POST['commentaires_post'])){
            $text = (String) (trim($text));
            if(empty($text)) {
                $valid = false;
                $er_commentaire = "Merci d'écrire un commentaire avant de valider";
          
            }
            if($valid){

                $requete = $bdd->prepare('INSERT INTO commentaires(id_user, username, id_acteur, commentaires) VALUES (?, ?, ?, ?)');
                $requete->execute(array($_SESSION['id_user'],$_SESSION['prenom'], $_GET['id_acteur'], $text));
                
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
</head>
<body>
    <header>
        <a href="accueil.php">
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
        $id = (int) $donnees['id_acteur'];
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
                    <p>1</p>
                    <a href="like_dislike.php?t=1&id_acteur=<?php echo $_GET['id_acteur']; ?>">
                        <img src="img/like.png" alt="">
                    </a>
                    <p>1</p>
                    <a href="like_dislike.php?t=2&id_acteur=<?php echo $_GET['id_acteur']; ?>">
                        <img src="img/dislike.png" alt="">
                    </a>
                </div>
            </div>
            <?php
            $req = $bdd->prepare('SELECT * FROM commentaires WHERE id_acteur = ?');
            $req->execute(array($_GET['id_acteur']));
            while($commentaire = $req->fetch())
            {
            ?>
                <div id="dernier_com">
                    <article>
                        <div class="header_dernier_com">
                            <h4><?php echo $commentaire['username']; ?> </h4>
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
                    <textarea name="text" placeholder="Votre commentaire..."></textarea>
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