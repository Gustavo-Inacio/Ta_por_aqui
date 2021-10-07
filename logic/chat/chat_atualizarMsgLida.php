<?php
session_start();
require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//A cada 0.5s o usuário da sessão vai passar por esse script, o qual irá verificar se as mensagens dele foram lidas ou não

$query = "SELECT mensagem_lida from chat_mensagens WHERE id_chat_contato = :contato AND id_remetente_usuario = :rementente ORDER BY id_chat_mensagem DESC LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindValue(':contato', $_POST['id_contato']);
$stmt->bindValue(':rementente', $_SESSION['idUsuario']);
$stmt->execute();

$ultimaMsgLida = $stmt->fetch(PDO::FETCH_OBJ)->mensagem_lida;
echo $ultimaMsgLida;