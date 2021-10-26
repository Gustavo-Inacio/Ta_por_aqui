<?php

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$categoria_motivo = $_GET['type'] === 'comment' ? 2 : 1;

$query = "SELECT id_denuncia_motivo, denuncia_motivo FROM denuncia_motivo WHERE categoria_motivo = $categoria_motivo";
$motivos = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($motivos);