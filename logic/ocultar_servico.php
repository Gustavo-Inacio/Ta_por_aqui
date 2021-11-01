<?php
session_start();

require "editar_servico_brain.php";
$editarServico = new editService($_POST['serviceID']);

$con = $editarServico->getCon();

//próprio serviço
if (!$editarServico->verifySelfService()){
    //não é o prório serviço
    echo 'Não foi possível alterar o serviço. Erro ao passar o ID';
} else {
    //pegando o status atual do serviço
    $query = "SELECT status_servico from servicos WHERE id_servico = {$_POST['serviceID']}";
    $currentStatus = $con->query($query)->fetch(PDO::FETCH_OBJ)->status_servico;
    $changeTo = $currentStatus == 1 ? 3 : 1;

    $query = "UPDATE servicos SET status_servico = $changeTo WHERE id_servico = {$_POST['serviceID']}";
    $con->query($query);

    echo $changeTo;
}