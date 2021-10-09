<?php

require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

if ($_POST['mensagem_chat'] == ''){
    exit();
}

//inserindo mensagem no banco de dados
$query = "INSERT INTO chat_mensagens(id_chat_contato, id_remetente_usuario, id_destinatario_usuario, mensagem_chat) VALUE (:id_chat_contato, :id_remetente_usuario, :id_destinatario_usuario, :mensagem_chat)";
$stmt = $con->prepare($query);
$stmt->bindValue(':id_chat_contato', $_POST['id_chat_contato']);
$stmt->bindValue(':id_remetente_usuario', $_POST['id_remetente_usuario']);
$stmt->bindValue(':id_destinatario_usuario', $_POST['id_destinatario_usuario']);
$stmt->bindValue(':mensagem_chat', $_POST['mensagem_chat']);
$stmt->execute();

//atualizando contato
#atualizando contatato da conversa para mover pra cima
$query = "UPDATE chat_contatos SET ultima_att_contato = :ultima_att_contato WHERE id_chat_contato = :id_chat_contato";
$stmt = $con->prepare($query);
$stmt->bindValue(':ultima_att_contato', date('Y-m-d H:i:s'));
$stmt->bindValue(':id_chat_contato', $_POST['id_chat_contato']);
$stmt->execute();