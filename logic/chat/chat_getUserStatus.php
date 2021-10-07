<?php
require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

session_start();

//pegar quantas mensagens não lidas esse usuário tem
$query = "SELECT online_usuario FROM usuarios WHERE id_usuario = {$_GET['id_usuario']}";
$stmt = $con->query($query);
$statusUsuario = $stmt->fetch(PDO::FETCH_OBJ)->online_usuario;
echo $statusUsuario;