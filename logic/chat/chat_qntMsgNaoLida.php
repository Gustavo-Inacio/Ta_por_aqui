<?php
require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

session_start();
if (isset($_SESSION['idUsuario'])){
    //pegar quantas mensagens não lidas esse usuário tem
    $query = "SELECT count(*) as qnt FROM chat_mensagens WHERE id_destinatario_usuario = {$_SESSION['idUsuario']} AND mensagem_lida = false";
    $stmt = $con->query($query);
    $qntMsgNaoLida = $stmt->fetch(PDO::FETCH_OBJ)->qnt;
    echo $qntMsgNaoLida;
} else {
    echo 0;
}