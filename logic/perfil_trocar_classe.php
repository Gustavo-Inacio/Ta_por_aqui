<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "UPDATE usuarios set classif_usuario = :classificacao WHERE id_usuario = :idUsuario";
$stmt = $con->prepare($query);
$stmt->bindValue(":classificacao", (int)$_GET['newclass']);
$stmt->bindValue(":idUsuario", $_SESSION['idUsuario']);
$stmt->execute();

//atualizar novo email na session
$_SESSION['classificacao'] = (int)$_GET['newclass'];

//atualizar novo email nos cookies
if (isset($_COOKIE['classificacao'])){
    setcookie('classificacao', (int)$_GET['newclass'], time() + (60*60*24*30), '/');
}

if ($_GET['newclass'] === "0"){
    #indisponibilizando os serviços daquele usuário caso ele se torne prestador para cliente

    $query = "SELECT id_servico FROM servicos where id_prestador_servico = " . $_SESSION['idUsuario'] . " AND status_servico = 1";
    $stmt = $con->query($query);
    $servicosPrestador = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (count($servicosPrestador) !== 0){
        $invalidateServices = "UPDATE servicos SET status_servico = 0 WHERE id_prestador_servico = " . $_SESSION['idUsuario'] . " AND status_servico != 2";
        $stmt = $con->query($invalidateServices);

    }
    header('location:../public/Perfil/meu_perfil.php?status=classificacao%20alterada%20para%20cliente');
} else {
    #disponibilizando os serviços daquele usuário caso ele se torne cliente para prestador

    $query = "SELECT id_servico FROM servicos where id_prestador_servico = " . $_SESSION['idUsuario'] . " AND status_servico = 0";
    $stmt = $con->query($query);
    $servicosPrestador = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (count($servicosPrestador) !== 0){
        $invalidateServices = "UPDATE servicos SET status_servico = 1 WHERE id_prestador_servico = " . $_SESSION['idUsuario'] . " AND status_servico != 2";
        $stmt = $con->query($invalidateServices);

    }
    header('location:../public/Perfil/meu_perfil.php?status=classificacao%20alterada%20para%20prestador');
}