<?php
require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//pegando o ID da ultima mensagem
$query = "SELECT id_chat_mensagem from chat_mensagens WHERE id_chat_contato = :contato ORDER BY id_chat_mensagem DESC LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindValue(':contato', $_POST['id_chat']);
$stmt->execute();
$lastMessage = $stmt->fetch(PDO::FETCH_OBJ)->id_chat_mensagem;

echo $lastMessage;