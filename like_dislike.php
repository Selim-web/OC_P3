<?php  
    session_start();
    $bdd = new PDO('mysql:host=127.0.0.1;port=8889;dbname=GBAF','root', 'root'); 

    if(isset($_GET['id_acteur'],$_GET['t']) && !empty($_GET['id_acteur']) && !empty($_GET['t'])){
        
       if($_GET['t'] == 1) {
            $check_like = $bdd->prepare('SELECT * FROM likes WHERE id_acteur = ? AND id_user = ?');
            $check_like->execute(array($_GET['id_acteur'],$_SESSION['id_user']));

            $delete_dislike = $bdd->prepare('DELETE FROM dislikes WHERE id_acteur = ? AND id_user = ?');
            $delete_dislike->execute(array($_GET['id_acteur'],$_SESSION['id_user']));

            if($check_like->rowCount() == 1) {
                $delete_like = $bdd->prepare('DELETE FROM likes WHERE id_acteur = ? AND id_user = ?');
                $delete_like->execute(array($_GET['id_acteur'],$_SESSION['id_user']));
            }
            else {
                $like = $bdd->prepare('INSERT INTO likes (id_acteur,id_user) VALUE (?,?)');
                $like->execute(array($_GET['id_acteur'],$_SESSION['id_user']));
            }    
       }
       elseif ($_GET['t'] == 2) {
            $check_dislike = $bdd->prepare('SELECT * FROM dislikes WHERE id_acteur = ? AND id_user = ?');
            $check_dislike->execute(array($_GET['id_acteur'],$_SESSION['id_user']));

            $delete_like = $bdd->prepare('DELETE FROM likes WHERE id_acteur = ? AND id_user = ?');
            $delete_like->execute(array($_GET['id_acteur'],$_SESSION['id_user']));

            if($check_dislike->rowCount() == 1) {
                $delete_dislike = $bdd->prepare('DELETE FROM dislikes WHERE id_acteur = ? AND id_user = ?');
                $delete_dislike->execute(array($_GET['id_acteur'],$_SESSION['id_user']));
            }
            else {
                $dislike = $bdd->prepare('INSERT INTO dislikes (id_acteur,id_user) VALUE (?, ?)');
                $dislike->execute(array($_GET['id_acteur'],$_SESSION['id_user']));
            }
       }
       header('Location:acteur_page.php?id_acteur=' . $_GET['id_acteur']);
    }
  
?>