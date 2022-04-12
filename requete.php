<?php

function create_user($name,$mail,$img){
    $db = connexion_BD();
    $sql = "INSERT INTO users(name_users,mail_users,img_users) VALUES (:name_users,:mail_users,:img_users)";
    $req = $db->prepare($sql);
    $result = $req->execute([":name_users"=>$name,":mail_users"=>$mail,":img_users"=>$img]);
}
function requete_findMail($mail) {
    $db = connexion_BD();
    $sql = "SELECT * FROM users WHERE mail_user = :mail";
    $req = $db->prepare($sql);
    $result = $req->execute([
        "mail"=>$mail
    ]);

    $data = $req->fetch(PDO::FETCH_OBJ);
    return $data;    
}
function requete_findUser($name) {
    $db = connexion_BD();
    $sql = "SELECT * FROM users WHERE name_users = :name_users";
    $req = $db->prepare($sql);
    $result = $req->execute([
        "name_users"=>$name
    ]);

    $data = $req->fetch(PDO::FETCH_OBJ);
    return $data;    
}
function order(){
    $db = connexion_BD();
    $sql = "SELECT * FROM users ORDER BY name_users";
    $req = $db->query($sql);
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
function modify($name,$mail,$img,$id) {
    $db = connexion_BD();
    $sql = "UPDATE users SET name_users = :name_users, mail_users = :mail_users, img_users = :img_users WHERE id_users = :id_users";
    $req = $db->prepare($sql);
    $result = $req->execute([
        "name_users"=>$name,
        "mail_users"=>$mail,
        "img_users"=>$img,
        "id_users"=>$id
        
    ]);
    return $result;
}
function requete_pseudo() {
    $db = connexion_BD();
    $sql = "SELECT * FROM users WHERE id_users = ($_SESSION[modifier])";
    $req = $db->query($sql);
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
}
function delete($id){
    $db = connexion_BD();
    $sql = "DELETE FROM users WHERE id_users = :id_users";
    $req = $db->prepare($sql);
    $result = $req->execute([
        "id_users"=>$id]);
}
