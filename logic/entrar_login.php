<?php
session_start();

//procurando login do usuário no banco de dados
require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "SELECT id_usuario, email, senha, classificacao FROM usuarios WHERE email = :email AND senha = :senha";
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

    //mantendo o usuário logado com cookies (caso desejado)

    header('Location: ../public/Home/home.html');
}