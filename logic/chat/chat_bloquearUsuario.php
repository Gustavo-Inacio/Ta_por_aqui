<?php
require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$status_contato = $_POST['statusContato'] == 0 ? 0 : 1;
$quem_bloqueou = $status_contato === 1 ? null : $_POST['idUsuario'];

//Bloquear/desbloqueando usuário settando o status de contato como 0 (bloqueado) ou 1(desbloqueado)
$query = "UPDATE chat_contatos set status_chat_contato = :status_contato, quem_bloqueou_contato = :idUsuario WHERE id_chat_contato = :id_chat_contato";
$stmt = $con->prepare($query);
$stmt->bindValue(':status_contato', $status_contato);
$stmt->bindValue(':idUsuario', $quem_bloqueou);
$stmt->bindValue(':id_chat_contato', $_POST['idChatContato']);
$stmt->execute();

//Retirando usuário dos contatos favoritos caso esteja-se bloqueando
if ($status_contato == 0){
    $query = "DELETE FROM chat_contatos_favoritos WHERE id_usuario = :id_usuario AND id_chat_contato = :id_chat_contato";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_usuario', $_POST['idUsuario']);
    $stmt->bindValue(':id_chat_contato', $_POST['idChatContato']);
    $stmt->execute();
}