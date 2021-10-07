<?php
session_start();
require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//Quando o usuário passar por esse script, ele marcará todas as mensagens do destinatário como lidas

$query = "UPDATE chat_mensagens set mensagem_lida = true WHERE id_chat_contato = :contato AND id_remetente_usuario != :rementente";
$stmt = $con->prepare($query);
$stmt->bindValue(':contato', $_POST['id_contato']);
$stmt->bindValue(':rementente', $_SESSION['idUsuario']);
$stmt->execute();
