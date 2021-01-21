<?php  
    session_start();

    if (!isset($_SESSION['id_user'])){
        header('Location: connexion.php');
        exit;
    }

    if(!(isset($_GET['id_acteur'],$_GET['type']) && 
        !empty($_GET['id_acteur']) && 
        !empty($_GET['type']))){
        return header('Location:acteur_page.php?id_acteur=' . $_GET['id_acteur']);
    }
    
switch($_GET['type']) {
    case 1:
        toggle_like($_GET['id_acteur'], $_SESSION['id_user']);
        break;
    case 2:
        toggle_dislike($_GET['id_acteur'], $_SESSION['id_user']);
        break;
    case 3:
        default;
}

function toggle_like($id_acteur,$id_user) {
    $checklike = check_like($id_acteur, $id_user);

    delete_dislike($id_acteur,$id_user);
    if($checklike == 1) {
        delete_like($id_acteur,$id_user);
    }
    else {
        insert_like($id_acteur,$id_user);
    }
    return header('Location:acteur_page.php?id_acteur=' . $_GET['id_acteur']);
}

function toggle_dislike($id_acteur,$id_user) {
    $checkdislike = check_dislike($id_acteur, $id_user);

    delete_like($id_acteur,$id_user);
    if($checkdislike == 1) {
        delete_dislike($id_acteur,$id_user);
    }
    else {
        insert_dislike($id_acteur,$id_user);
    }
    return header('Location:acteur_page.php?id_acteur=' . $_GET['id_acteur']);
}

function check_like($id_acteur, $id_user) {
    
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-'); 
    $check_like = $bdd->prepare('SELECT * FROM likes WHERE id_acteur = ? AND id_user = ?');
    $check_like->execute(array($id_acteur,$id_user));
    return $check_like->rowCount();
}

function check_dislike($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-'); 

    $check_dislike = $bdd->prepare('SELECT * FROM dislikes WHERE id_acteur = ? AND id_user = ?');
    $check_dislike->execute(array($id_acteur,$id_user));
    return $check_dislike->rowCount();
}

function insert_like($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-'); 

    $like = $bdd->prepare('INSERT INTO likes (id_acteur,id_user) VALUE (?,?)');
    $like->execute(array($id_acteur,$id_user));    
}

function insert_dislike($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-'); 

    $dislike = $bdd->prepare('INSERT INTO dislikes (id_acteur,id_user) VALUE (?,?)');
    $dislike->execute(array($id_acteur,$id_user));    
}

function delete_like($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-'); 

    $delete_like = $bdd->prepare('DELETE FROM likes WHERE id_acteur = ? AND id_user = ?');
    $delete_like->execute(array($id_acteur,$id_user));
}

function delete_dislike($id_acteur, $id_user) {
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=openclassrooms_p3.bouhassatine-selim.fr_2020','SELIMP3_ADMIN', '-BddSelim2020!-'); 

    $delete_dislike = $bdd->prepare('DELETE FROM dislikes WHERE id_acteur = ? AND id_user = ?');
    $delete_dislike->execute(array($id_acteur,$id_user));
}



?>