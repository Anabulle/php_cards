<?php
session_start();
include 'pdo.php';
include 'requete.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <h1>créez votre carte !</h1>
    <div id="container">
        <form id="bloc" action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="name_users">votre nom</label>
                <input type="text" size="30" id="name_users" name="name_users">
            </div>
            <div>
                <label for="mail_users">votre mail</label>
                <input type="text" size="30" id="mail_users" name="mail_users">
            </div>
            <input type="file" name="img" id="img">
            <input type="submit" value="envoyez" id="valider" name="valider">
        </form>
    </div>
    <?php

    if (isset($_POST['valider'])) {
        if (isset($_POST['name_users'], $_POST['mail_users'])) {
            if ($_FILES['img']['size'] > 0) {
                $tmpName = $_FILES['img']['tmp_name'];
                $name_img = $_FILES['img']['name'];
                $size = $_FILES['img']['size'];
                $type = $_FILES['img']['type'];
                $name_users = $_POST['name_users'];
                $error = null;
                $extension = ['jpg', 'jpeg', 'png'];
                $ext = explode('/', $type);
                $nom = requete_findUser($name_users);
                $url = $name_users . '.' . $ext[1];
                if ($size >= 1000000) {
                    $error = "taille d image ";
                }
                if ($ext[1] !== 'jpeg' and $ext[1] !== 'png' and $ext[1] !== 'jpg') {
                    $error .= "extension ";
                }
                if ($nom) {
                    $error .= "nom déja enregistrer";
                }

                if (requete_findMail($_POST['mail_users'])) {

                    $error .= "ce mail est déja utilisé";
                }
                if ($error != null) {
                    echo "les erreurs suivantes ont été détéctés : $error";
                } else {
                    echo "<p> l'utilisateur a été ajouté avec succès </p>";
                    move_uploaded_file($tmpName, 'assets/img/' . $name_users . '.' . $ext[1]);
                    create_user($name_users, $_POST['mail_users'], $url);
                }
            }
        } else {
            echo "veuillez saisir les informations";
        }
    }

    $order = order();

    foreach ($order as $value) {
        echo "<div class =" . "card" . ">";
        echo "<img src=" . "assets/img/$value->img_users " . ">";
        echo "<p> $value->name_users </p>";
        echo "<p>$value->mail_users</p>";
        echo "<form" . " method=" . " get" . ">";
        echo "<div id=" . "press" . ">";
        echo "<button type=" . " submit" . " name=" . " supprimer" . " value=" . "$value->id_users" . ">" . "Supprimer" . "</button>";
        echo "<button type=" . " submit" . " name=" . " modifier" . " value=" . "$value->id_users" . ">" . "Modifier" . "</button>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
    }
    if (!empty($_GET['supprimer'])) {
        $id = $_GET['supprimer'];
        delete($id);
    }
    if(!empty($_GET['modifier'])){
        $_SESSION['modifier'] = $_GET['modifier'];
        header('Location: modification.php');
    }
    ?>


</body>

</html>