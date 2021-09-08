<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

if ($_POST['contactName'] === "" || $_POST['contactEmail'] === "" || $_POST['contactPhone'] === "" || $_POST['contactMessage'] === "" || $_POST['contactReason'] === ""){
    header('location: ../public/Contato/contato.php?status=0');
    exit();
}

$sql = 'INSERT INTO fale_conosco(nome_contato, email_contato, motivo_contato, fone_contato, msg_contato) VALUES(:nome, :email, :motivo, :telefone, :mensagem)';
$stmt = $con->prepare($sql);
$stmt->execute(['nome' => $_POST['contactName'], 'email' => $_POST['contactEmail'], 'motivo' => $_POST['contactReason'], 'telefone' => $_POST['contactPhone'], 'mensagem' => $_POST['contactMessage']]);

header('location: ../public/Contato/contato.php?status=1');