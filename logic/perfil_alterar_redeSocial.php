<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//tratando os campos null
foreach ($_POST as $i => $rede_social){
    if ($_POST[$i][0] === ""){
        $_POST[$i][0] = null;
    }
    if ($_POST[$i][1] === ""){
        $_POST[$i][1] = null;
    }
}

echo "<pre>";
print_r($_POST);
echo "</pre>";

//verificando os links da rede social
$valid = true;

#verificando instagram
if ($_POST['instagram'][0] !== null && $_POST['instagram'][1] !== null){
    if (!str_contains($_POST['instagram'][1], "https://www.instagram.com/")){
        header('location: ../public/Perfil/meu_perfil.php');
        exit();
    }
}

if ($_POST['facebook'][0] !== null && $_POST['facebook'][1] !== null){
    if (!str_contains($_POST['facebook'][1], "https://www.facebook.com/")){
        header('location: ../public/Perfil/meu_perfil.php');
        exit();
    }
}

if ($_POST['twitter'][0] !== null && $_POST['twitter'][1] !== null){
    if (!str_contains($_POST['twitter'][1], "https://twitter.com/")){
        header('location: ../public/Perfil/meu_perfil.php');
        exit();
    }
}

if ($_POST['linkedin'][0] !== null && $_POST['linkedin'][1] !== null){
    if (!str_contains($_POST['linkedin'][1], "https://br.linkedin.com/in/")){
        header('location: ../public/Perfil/meu_perfil.php');
        exit();
    }
}

//update no instagram
$query1 = "UPDATE usuario_redes_sociais SET nome_usuario = :nome_instagram, link_perfil = :link_instagram WHERE rede_social = 'instagram' AND id_usuario = :id_usuario";
$stmt1 = $con->prepare($query1);
$stmt1->bindValue(":nome_instagram", $_POST['instagram'][0]);
$stmt1->bindValue(":link_instagram", $_POST['instagram'][1]);
$stmt1->bindValue(":id_usuario", $_SESSION['idUsuario']);
$stmt1->execute();

//update no facebook
$query2 = "UPDATE usuario_redes_sociais SET nome_usuario = :nome_facebook, link_perfil = :link_facebook WHERE rede_social = 'facebook' AND id_usuario = :id_usuario";
$stmt2 = $con->prepare($query2);
$stmt2->bindValue(":nome_facebook", $_POST['facebook'][0]);
$stmt2->bindValue(":link_facebook", $_POST['facebook'][1]);
$stmt2->bindValue(":id_usuario", $_SESSION['idUsuario']);
$stmt2->execute();

//update no twitter
$query3 = "UPDATE usuario_redes_sociais SET nome_usuario = :nome_twitter, link_perfil = :link_twitter WHERE rede_social = 'twitter' AND id_usuario = :id_usuario";
$stmt3 = $con->prepare($query3);
$stmt3->bindValue(":nome_twitter", $_POST['twitter'][0]);
$stmt3->bindValue(":link_twitter", $_POST['twitter'][1]);
$stmt3->bindValue(":id_usuario", $_SESSION['idUsuario']);
$stmt3->execute();

//update no linkedin
$query4 = "UPDATE usuario_redes_sociais SET nome_usuario = :nome_linkedin, link_perfil = :link_linkedin WHERE rede_social = 'linkedin' AND id_usuario = :id_usuario";
$stmt4 = $con->prepare($query4);
$stmt4->bindValue(":nome_linkedin", $_POST['linkedin'][0]);
$stmt4->bindValue(":link_linkedin", $_POST['linkedin'][1]);
$stmt4->bindValue(":id_usuario", $_SESSION['idUsuario']);
$stmt4->execute();

header('location: ../public/Perfil/meu_perfil.php');