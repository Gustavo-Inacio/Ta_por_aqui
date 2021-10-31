<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] == ""){
    echo json_encode([0 => 'not logged']);
    exit();
}

if ($_POST['reportType'] === 'service'){
    $query = "INSERT INTO denuncia_servico(id_servico, id_denuncia_motivo, id_usuario, desc_denuncia_serv) values (:id_servico, :id_denuncia_motivo, :id_usuario, :desc_denuncia_serv)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_servico', $_POST['serviceId']);
    $stmt->bindValue(':id_denuncia_motivo', $_POST['reasonId']);
    $stmt->bindValue(':id_usuario', $_SESSION['idUsuario']);
    $stmt->bindValue(':desc_denuncia_serv', $_POST['reportDesc']);
    $stmt->execute();

    echo json_encode($stmt->errorInfo());
} else if ($_POST['reportType'] === 'comment'){
    $query = "INSERT INTO denuncia_comentario(id_comentario, id_denuncia_motivo, id_usuario, desc_denuncia_comen) values (:id_comentario, :id_denuncia_motivo, :id_usuario, :desc_denuncia_comen)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_comentario', $_POST['commentId']);
    $stmt->bindValue(':id_denuncia_motivo', $_POST['reasonId']);
    $stmt->bindValue(':id_usuario', $_SESSION['idUsuario']);
    $stmt->bindValue(':desc_denuncia_comen', $_POST['reportDesc']);
    $stmt->execute();

    echo json_encode($stmt->errorInfo());
}