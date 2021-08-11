<?php
session_start();
require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

if ($_SESSION['imagemPerfil'] !== "no_picture.jpg"){
    //remover foto da pasta do servidor
    $dirImg = "../assets/images/users/".$_SESSION['imagemPerfil'];

    if ( unlink($dirImg) ) {
        //trocar nome no banco de dados para referenciar para a no_picture.jpg
        $query = "UPDATE usuarios SET imagem_perfil = 'no_picture.jpg'";
        $stmt = $con->query($query);

        //trocar da session e do cookie
        $_SESSION['imagemPerfil'] = 'no_picture.jpg';
        if (isset($_COOKIE['imagemPerfil'])){
            setcookie('imagemPerfil', "no_picture.jpg", time() + (60*60*24*30), '/');
        }

        header('location: ../public/Perfil/meu_perfil.php');
    } else {
        header('location: ../public/Perfil/meu_perfil.php?erro=nao%20foi%20possivel%20apagar%20a%20foto');
    }
} else {
    header('location: ../public/Perfil/meu_perfil.php');
}