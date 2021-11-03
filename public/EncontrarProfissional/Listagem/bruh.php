<?php 
    require '../../../logic/DbConnection.php';
    $connectClass = new DbConnection();
    $con = $connectClass->connect();

    $cmd = $con->query("select * from servicos where id_prestador_servico=6;");
    print_r($cmd);
    $resp = $cmd->fetchAll(PDO::FETCH_ASSOC);

    if($resp == true){
        echo "exsite";
    }
    else{
        echo "não existe esse servio aí não";
    }

    echo '<pre>';
    print_r($resp);
    echo '<pre>';

?>