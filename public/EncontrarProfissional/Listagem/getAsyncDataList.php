<?php
    $reponse = false;
    session_start();
    if(! $_SESSION['listServices']) {
        $reponse = false;
        echo json_encode($reponse);
    }

    require '../../../logic/listagem_brain.php';
    
    $brain = new serviceList();

    $request = json_decode(file_get_contents("php://input"));

    $reponse['categoires'] = $brain->getCatgorieInfo();
    $reponse['brh'] = "oi";
      print_r($reponse);
    $a = json_encode($reponse);

    print_r($a);
?>