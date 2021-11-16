<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//remover serviço dos serviços salvos
$query = "UPDATE usuarios set mostrar_local_usuario = {$_POST['changeTo']} WHERE id_usuario = {$_SESSION['idUsuario']}";
$stmt = $con->query($query);

echo $_POST['changeTo'];