<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//remover serviço dos serviços salvos
$query = "DELETE FROM servicos_salvos where id_servico_salvo = " . $_GET['id'];
$stmt = $con->query($query);

header('location: ../public/Perfil/meu_perfil.php');