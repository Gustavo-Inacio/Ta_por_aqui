<?php
session_start();

//procurando login do usuário no banco de dados
require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "SELECT id_usuario, email_usuario, senha_usuario, classif_usuario, imagem_usuario FROM usuarios WHERE email_usuario = :email AND senha_usuario = :senha AND status_usuario = 1";
$stmt = $con->prepare($query);
$stmt->bindValue(":email", $_POST['loginEmail']);
$stmt->bindValue(":senha", $_POST['loginPass']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);

if( empty($user) ){
    //redirecionando para página de login pois está inválido
    header('Location: ../public/Entrar/login.php?erro=login_invalido');
} else {
    //criando a session do usuário
    $_SESSION['idUsuario'] = $user->id_usuario;
    $_SESSION['email'] = $user->email_usuario;
    $_SESSION['senha'] = $user->senha_usuario;
    $_SESSION['classificacao'] = $user->classif_usuario;
    $_SESSION['imagemPerfil'] = $user->imagem_usuario;

    //mantendo o usuário logado com cookies (caso desejado)
    if( isset($_POST['stayLogged']) ){
        setcookie('idUsuario', $user->id_usuario, time() + (60*60*24*30), '/'); //expira em 30 dias
        setcookie('email', $user->email_usuario, time() + (60*60*24*30), '/');
        setcookie('senha', $user->senha_usuario, time() + (60*60*24*30), '/');
        setcookie('classificacao', $user->classif_usuario, time() + (60*60*24*30), '/');
        setcookie('imagemPerfil', $user->imagem_usuario, time() + (60*60*24*30), '/');
    }

    header('Location: ../public/Home/home.php');
}