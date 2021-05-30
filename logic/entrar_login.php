<?php
session_start();

//procurando login do usuário no banco de dados
require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "SELECT id_usuario, email, senha, classificacao, imagem_perfil FROM usuarios WHERE email = :email AND senha = :senha";
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
    $_SESSION['email'] = $user->email;
    $_SESSION['senha'] = $user->senha;
    $_SESSION['classificacao'] = $user->classificacao;
    $_SESSION['imagemPerfil'] = $user->imagem_perfil;

    //mantendo o usuário logado com cookies (caso desejado)
    if( isset($_POST['stayLogged']) ){
        setcookie('idUsuario', $user->id_usuario, time() + (60*60*24*30), '/'); //expira em 30 dias
        setcookie('email', $user->email, time() + (60*60*24*30), '/');
        setcookie('senha', $user->senha, time() + (60*60*24*30), '/');
        setcookie('classificacao', $user->classificacao, time() + (60*60*24*30), '/');
        setcookie('imagemPerfil', $user->imagem_perfil, time() + (60*60*24*30), '/');
    }

    header('Location: ../public/Home/home.php');
}