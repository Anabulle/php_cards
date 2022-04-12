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
    <?php
    
    $info = requete_pseudo();
    ?>
    <h2>modifiez vos informations !</h2>
    <div id="container">
        <form id="bloc" action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="name_users">votre nom</label>
                <input type="text" size="30" id="name_users" name="name_users" <?php echo "value=".$info[0]->name_users; ?>>
            </div>
            <div>
                <label for="mail_users">votre mail</label>
                <input type="text" size="30" id="mail_users" name="mail_users"  <?php echo "value=".$info[0]->mail_users; ?>>
            </div>
            <input type="file" name="img" id="img" >
            <input type="submit" value="envoyez" id="valider" name="valider">
        </form>
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
                        echo "<p> l'utilisateur a été modifié avec succès </p>";
                        move_uploaded_file($tmpName, 'assets/img/' . $name_users . '.' . $ext[1]);
                        modify($name_users, $_POST['mail_users'], $url, $_SESSION['modifier']);
                        session_destroy(); //destroy the session
                        header("location: index.php");
                        exit();
                    }
                }
            } else {
                echo "veuillez saisir les informations";
            }
        }

        ?>
</body>

</html>