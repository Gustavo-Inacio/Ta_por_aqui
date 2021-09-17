<?php

session_start();
require "getData.php";

//conectar com o banco
$con = new DbConnection();
$con = $con->connect();

$query = "SELECT * from administradores where email_adm = :email and senha_adm = :senha";
$stmt = $con->prepare($query);
$stmt->bindValue(':email', $_POST['emailAdm']);
$stmt->bindValue(':senha', $_POST['passAdm']);
$stmt->execute();
$login = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($login)) {
    header('location:../index.php?login=erro');
} else {
    //criar sessão
    $_SESSION['idAdm'] = $login['id_adm'];
    $_SESSION['emailAdm'] = $login['email_adm'];
    $_SESSION['senhaAdm'] = $login['senha_adm'];

    //redirecionar
    header('Location:../analisys.php');
}