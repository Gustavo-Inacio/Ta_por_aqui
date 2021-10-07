<?php

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

session_start();
if (isset($_SESSION['idUsuario'])) {
    //Online ou offline
    if ($_POST['setUser'] === 'online'){
        //Colocar o status do usuário como online
        $query = "UPDATE usuarios SET online_usuario = true WHERE id_usuario = {$_SESSION['idUsuario']}";
        $con->query($query);
    } else {
        //Colocar o status do usuário como offline
        $query = "UPDATE usuarios SET online_usuario = false WHERE id_usuario = {$_SESSION['idUsuario']}";
        $con->query($query);
    }
}