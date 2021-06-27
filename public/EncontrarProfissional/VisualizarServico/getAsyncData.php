<?php
    session_start();
    require '../../../logic/visualizar_servico.php';

    if(!isset($_SESSION['serviceID'])){
      $reponse = false;
    }
    
    $serviceID = $_SESSION["serviceID"];

    $brain = new VisualizeService($serviceID);

    $inputData = json_decode(file_get_contents("php://input"));
    $reponse = false;

    if(isset($inputData->averageRate) && $inputData->averageRate == "true"){
        $reponse['averageRate'] = $brain->getServiceProviderAverage($serviceID);
    }

    if(isset($inputData->comments) && $inputData->comments == "true"){
      $reponse['comments'] = $brain->getComments();
    }

    if(isset($inputData->sendComment) && $inputData->sendComment == "true"){
      if(isset($_SESSION['idUsuario'])){
          if(isset($inputData->sendCommentData)){
            $reponse['sendComment'] = $brain->setAvaliation($_SESSION['idUsuario'], $inputData->sendCommentData->comment, $inputData->sendCommentData->rateNumber);
          }
      }
    }

    if(isset($_GET['getOtherServices'])){ // pelo metho GET
        $config = json_decode($_GET['getOtherServices']);
        
        if($config->getOtherServices == true){
            $reponse['getOtherServices'] = $brain->getOtherService($config->sql);
        }
    }

    if(isset($inputData->saveService) && $inputData->saveService == "true"){
        $reponse['saveService'] = $brain->setSaveService($_SESSION['idUsuario']);
    }
    
    echo json_encode($reponse);

?>