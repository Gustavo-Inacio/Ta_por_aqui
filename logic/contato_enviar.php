<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$nome = $_POST['contactName'];
$email = $_POST['contactEmail'];
$empresa = $_POST['contactCompany'];
$telefone = $_POST['contactPhone'];
$mensagem = $_POST['contactMessage'];

$sql = "INSERT INTO fale_conosco(nome, email, empresa, telefone, mensagem) VALUES($nome, $email, $empresa, $telefone, $mensagem)"

if (mysql_query($con, $sql)) {
    echo "<script>alert('Sua mensagem foi enviada com sucesso')</script>";
} else {
    echo "<script>alert('Houve um erro ao enviar sua mensagem')</script>";
}


?>