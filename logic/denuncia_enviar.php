<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

echo "<pre>";
print_r($_POST);
echo "</pre>";

if ($_POST['reportType'] === 'service'){
    $query = "INSERT INTO denuncia_servico(id_servico, id_denuncia_motivo, id_usuario, desc_denuncia_serv) values (:id_servico, :id_denuncia_motivo, :id_usuario, :desc_denuncia_serv)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_servico', $_POST['serviceId']);
    $stmt->bindValue(':id_denuncia_motivo', $_POST['reasonId']);
    $stmt->bindValue(':id_usuario', $_SESSION['idUsuario']);
    $stmt->bindValue(':desc_denuncia_serv', $_POST['reportDesc']);
    $stmt->execute();
} else if ($_POST['reportType'] === 'comment'){
    $query = "INSERT INTO denuncia_comentario(id_comentario, id_denuncia_motivo, id_usuario, desc_denuncia_comen) values (:id_comentario, :id_denuncia_motivo, :id_usuario, :desc_denuncia_comen)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_comentario', $_POST['commentId']);
    $stmt->bindValue(':id_denuncia_motivo', $_POST['reasonId']);
    $stmt->bindValue(':id_usuario', $_SESSION['idUsuario']);
    $stmt->bindValue(':desc_denuncia_comen', $_POST['reportDesc']);
    $stmt->execute();
}

if ($_POST['currentUrl']){

}

header('Location:' . $_POST['currentUrl']);