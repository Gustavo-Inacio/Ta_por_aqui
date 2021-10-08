<?php
if( empty($_SESSION['idUsuario']) ){
    if( isset($_COOKIE['idUsuario']) && isset($_COOKIE['email']) && isset($_COOKIE['senha']) && isset($_COOKIE['classificacao']) ){
        //criando a session do usuário
        $_SESSION['idUsuario'] = $_COOKIE['idUsuario'];
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['senha'] = $_COOKIE['senha'];
        $_SESSION['classificacao'] = $_COOKIE['classificacao'];
        $_SESSION['imagemPerfil'] = $_COOKIE['imagemPerfil'];
    }
}