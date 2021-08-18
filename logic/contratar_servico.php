<?php 
// Este script eh reponsavel por verificar, atualizar ou inserir um contrato de um servico informado pela session, por usuariaqui que esta na sessin tambem
require 'DbConnection.php';
session_start();

$response = array( // essa eh o array de resposta, eh o que sera retornado.
    'logged' => false, // indica se o usuario esta logado
    'finished' => false, // indica se o script foi ate o fim
    'alreadyExists' => false, // indica se o contrato ja esxistia no banco
    'setData' => false, // indica se o script teve que colocar um novo registro no bd
    'updatedData' => false, // indica se o script teve que atualizar o registro no bd
    'status' => -1 // indica o status no bd
);

if(!isset($_SESSION['idUsuario']) || !isset($_SESSION['serviceID'])){ // se nao existir um id, ou se nao existir um servico na session
    $response['logged'] = false; // nao esta logado
    $response = json_encode($response); // monta um jason para a reposta
    echo $response; // retorna a resposta
    exit(); // sai do codigo
}
else{
    $response['logged'] = true; // esta logado

    $connectClass = new DbConnection();
    $con = $connectClass->connect(); // invoca uma conexao
    
    $serviceID = $_SESSION['serviceID'];

    $command = $con->prepare("SELECT status_contrato FROM contratos WHERE id_servico=:id_ser AND id_cliente=:id_cli");
    $command->bindValue(":id_ser", $_SESSION['serviceID']);
    $command->bindValue(":id_cli", $_SESSION['idUsuario']);
    $command->execute(); // retorna o status de um contrato, se exisitr, entre um cliente e o servico

    if($command->rowCount() > 0){ // caso ja exista algum registro na tabela
        $statusData = $command->fetch(PDO::FETCH_ASSOC); // extrai o valor do status do contrato 

        if($statusData['status_contrato'] == 2){ // caso o valor for 2 (nao aceito), ele atualiza o pedido de contrato (status) para  0 (pendente)
            $cmd = $con->prepare("UPDATE contratos SET status_contrato=0 WHERE id_servico=:id_ser AND id_cliente=:id_cli");
            $cmd->bindValue(":id_ser", $_SESSION['serviceID']);
            $cmd->bindValue(":id_cli", $_SESSION['idUsuario']);
            $cmd->execute();
            $response['updatedData'] = true; // retona que o registro foi atualizado
        }
        else {
            $response['alreadyExists'] = true; // se o valor nao for zero, significa que do pode ser 0 (pedido pendente) ou 1(pedido aceito). nao faz nada, e retorna que ja existe.
        }
        
    }
    else{ // caso  o registro ainda nao exista na tabela
        $command = $con->query("SELECT id_prestador_servico FROM servicos WHERE id_servico='$serviceID'");
        $provider_id = $command->fetch(PDO::FETCH_ASSOC); // id do prestador do servico atual, que devera ser insireido posteriormente na tabela de contratos

        $stmt = $con->prepare('INSERT INTO contratos (id_servico, id_cliente, id_prestador, status_contrato) VALUES (:id_ser, :id_cli, :id_pres, :contract_stat)');
        $stmt->bindValue(":id_ser", $_SESSION['serviceID']);
        $stmt->bindValue(":id_cli", $_SESSION['idUsuario']);
        $stmt->bindValue(":id_pres", $provider_id['id_prestador_servico']);
        $stmt->bindValue(":contract_stat", 0);
        $stmt->execute(); // inclui um registro de pedido pendente na tabela de contratos entre o prestador, o servico e o cliente.

        if($stmt){
            $response['setData'] = true; // reponde que o dado foi colocado no bd.
        }

        
    }
    
    $cmdSatus = $con->prepare("SELECT status_contrato FROM contratos where id_servico=:id_ser and id_cliente=:id_cli");
    $cmdSatus->bindValue(":id_ser", $_SESSION['serviceID']);
    $cmdSatus->bindValue(":id_cli", $_SESSION['idUsuario']);
    $cmdSatus->execute();
    if($cmdSatus->rowCount() > 0){
        $response['status'] = $cmdSatus->fetch(PDO::FETCH_ASSOC)['status_contrato'];
    }

    $response['finished'] = true; // reponde que o scripit foi ate o fim
}

$response = json_encode($response); // transforma a reposta de array para json
echo $response; // retona a reposta no formato de json
