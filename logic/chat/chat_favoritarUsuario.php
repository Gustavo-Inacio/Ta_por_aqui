<?php
require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

if ($_POST['acao'] === 'favoritar'){
    $query = "INSERT INTO chat_contatos_favoritos(id_usuario, id_chat_contato) VALUE (:id_usuario, :id_chat_contato)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_usuario', $_POST['idUsuario']);
    $stmt->bindValue(':id_chat_contato', $_POST['idChatContato']);
    $stmt->execute();
} else {
    $query = "DELETE FROM chat_contatos_favoritos WHERE id_usuario = :id_usuario AND id_chat_contato = :id_chat_contato";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_usuario', $_POST['idUsuario']);
    $stmt->bindValue(':id_chat_contato', $_POST['idChatContato']);
    $stmt->execute();
}