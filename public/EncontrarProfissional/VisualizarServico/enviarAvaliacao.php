<?php
   // print_r(file_get_contents("php://input"));
    session_start();

    $response = false;

    if(!isset($_SESSION['idUsuario']) || !isset($_SESSION['serviceID'])){
        echo $response;
        exit();
    }

    require '../../../logic/visualizar_servico.php';

    $inputData = json_decode(file_get_contents("php://input"));

    $brain = new VisualizeService($_SESSION['serviceID']);
    
    //echo 'recebi a bagaca';
    echo json_encode($brain->setAvaliation($_SESSION['idUsuario'], $inputData->comment, $inputData->rateNumber));

?>