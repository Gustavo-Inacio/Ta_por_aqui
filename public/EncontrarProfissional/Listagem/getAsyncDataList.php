<?php
    $reponse = false;
    session_start();
    if(! $_SESSION['listServices']) {
        $reponse = false;
        echo json_encode($reponse);
    }

    require '../../../logic/listagem_brain.php';
    
    $brain = new serviceList();

    $inputData = json_decode(file_get_contents("php://input"));

    if(isset($inputData->getCategories) && $inputData->getCategories == "true"){
        $reponse['categoires'] = $brain->getCatgorieInfo();
        print_r($reponse['categoires']);
       // echo "get cat";
    }

    if(isset($inputData->getServices) && $inputData->getServices == "true"){
        if($inputData->dataServices) {
            $reponse['services'] = $brain->getServices($inputData->dataServices);
        }
        //echo 'get servi';
    }

    $a = json_encode($reponse);
    // print_r($inputData);
     print_r($a);
?>