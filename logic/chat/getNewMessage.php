<?php
$id_chat = $_POST['chatId'];
$id_ultima_msg = $_POST['lastMsgId'];

if ($id_ultima_msg == 0){
    echo "noMsg";
    exit();
}

session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//lendo mensagens do banco de dados
$query = "SELECT cm.id_chat_mensagem, cm.id_chat_contato, cm.id_remetente_usuario, cm.id_destinatario_usuario, cm.mensagem_chat, cm.diretorio_arquivo_chat, cm.apelido_arquivo_chat, cm.hora_mensagem_chat from chat_mensagens cm WHERE cm.id_chat_contato = :contato GROUP BY cm.id_chat_mensagem ORDER BY cm.id_chat_mensagem DESC LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindValue(':contato', $id_chat);
$stmt->execute();
$lastMessage = $stmt->fetch(PDO::FETCH_OBJ);

if ($id_ultima_msg == $lastMessage->id_chat_mensagem){
    echo "sameMsg";
} else {
    echo "differentMsg";
}