<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//0 = pendente, 1 = aceito, 2 = rejeitado
$choice = $_GET['escolha'] === 'accept' ? 1 : 2;
$contract = $_GET['contrato'];

$query = "UPDATE contratos SET status_contrato = $choice WHERE id_contrato = $contract";
$stmt = $con->query($query);

header('location: ../public/Perfil/meu_perfil.php');