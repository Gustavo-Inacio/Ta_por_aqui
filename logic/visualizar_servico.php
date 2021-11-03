<?php
require 'DbConnection.php';

class VisualizeService
{
    private $con;
    private $serviceID;

    public function __construct($serviceID){
        $connectClass = new DbConnection();
        $this->con = $connectClass->connect();

        $this->serviceID = $serviceID;
    }

    public function getPorviderInfo()
    {
        $data = array();

        // captura as infos do preatador que esteja relacionada a esse servico , sendo que o status do servico deva ser 1 'disponivel'
        $cmd_provider = $this->con->query("SELECT id_usuario, nome_usuario, sobrenome_usuario, classif_usuario, fone_usuario, uf_usuario, cidade_usuario, rua_usuario, numero_usuario 
        FROM usuarios, servicos where id_usuario = id_prestador_servico and id_servico={$this->serviceID}");
        
        $data = $cmd_provider->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getServiceInfo(){
        $data = [];

        $command = $this->con->query("SELECT id_servico, nome_servico, desc_servico, crit_orcamento_servico, tipo_servico, data_public_servico, nota_media_servico, orcamento_servico, status_servico FROM servicos WHERE id_servico='$this->serviceID'");
        $data = $command->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getServiceImages(){
        $data = [];

        // busca pelas fotos do servico, sendo que o status do servio deva ser 1
        $command = $this->con->query("SELECT dir_servico_imagem FROM servico_imagens, servicos WHERE servicos.id_servico=6 and servico_imagens.id_servico = servicos.id_servico");
        $data = $command->fetchAll(PDO::FETCH_COLUMN);

        return $data;
    }

    public function getComments(){
        $data = array(); // dados que serao retornados

        $cmdComment = $this->con->query("
        SELECT nota_comentario, servicos.id_servico, desc_comentario, usuarios.id_usuario,
        data_comentario, id_comentario, nome_usuario, sobrenome_usuario, imagem_usuario 
        FROM comentarios, servicos, usuarios 
        
        WHERE comentarios.id_servico={$this->serviceID} and comentarios.id_servico = servicos.id_servico 
        and usuarios.id_usuario = comentarios.id_usuario and status_comentario = 1 and status_usuario=1
        
        ORDER BY data_comentario DESC;");

        $dataComment = $cmdComment->fetchAll(PDO::FETCH_ASSOC);
        if($dataComment){
            $data = $dataComment;
        }

        return $data; // retorna os dados em formto de json.
    }

    public function getProviderAverage(){ // esta funcao retorna a quantidade de avaliacoes (comentarios), a soma de todas elas, e a média
        $response = array();// array de reponstas

        $cmdProviderId = $this->con->query("select id_prestador_servico from servicos where id_servico={$this->serviceID}");
        $respProviderId = $cmdProviderId->fetch(PDO::FETCH_ASSOC);

        if($respProviderId){

            $cmdAvgCount = $this->con->query("
                select count(nota_comentario) as quantity, nota_media_usuario from comentarios, servicos, usuarios
                where comentarios.id_servico = servicos.id_servico and 
                servicos.id_prestador_servico = usuarios.id_usuario and usuarios.id_usuario = {$respProviderId['id_prestador_servico']} and 
                status_usuario =1 ;
            ");

            $dataAvgCount = $cmdAvgCount->fetch(PDO::FETCH_ASSOC);
            if($dataAvgCount){
                $response = $dataAvgCount;
            }
        }

        return $response;
       
    }

    public function getAvaliationPermited(){
        $response = array(
            "status" => 2 // status de nao aceito - padrao
        );

        if(isset($_SESSION['idUsuario']) && isset($_SESSION['serviceID'])){
            $clientID = $_SESSION['idUsuario'];
            $serviceID = $_SESSION['serviceID'];

            $command = $this->con->query("SELECT status_contrato FROM contratos WHERE id_cliente='$clientID' AND id_servico='$serviceID'");

            if($command->rowCount() > 0){ // verifica se existe um contrato entre o sevico e esse user
                $statusData = $command->fetch(PDO::FETCH_ASSOC);
                $response['status'] = $statusData['status_contrato']; // se ja existir, responde com q que esta la
            }
            else{
                $response['status'] = 2; // se nao existir, coloca o valor padrao
            }

        
        }
        else{ // se nao estiver loggado ou nao estiver em um servico
            $response['status'] = 2; // status padrao 
        }

        return $response;
    }

    public function getServiceProviderAverage($serviceID){
        /*  Esta funcao calcula a media da nota do servico, e a media da nota do prestador.
            Portanto, ela deve ser chamada todas as vezes que um novo comentario ou avaliacao
            for inserido. 
            ELA SOMENTE RETORNA DADOS, ELA NAO ATUALIZA!!

            Recebe: um id de servico para analisar.

            Ela retorna um array com as infomacoes contidas na array '$response', que sao as informacoes
            atualizadas das medias, quantidade de availiacoes e a soma de todas elas.
        */
        
        $response = array( // array de reposta
            'provider' => array( // infos do provedor de servico
                'rateQuantity' => 0,
                'averageRate' => 0
            ),
            'service' => array(
                'rateQuantity' => 0,
                'averageRate' => 0
            ),
            'info' => array( // satus da funcoa
                'finished' => true, // se terminou = true
            )
        );

        $cmdProviderId = $this->con->query("select id_prestador_servico from servicos where id_servico={$this->serviceID}");
        $respProviderId = $cmdProviderId->fetch(PDO::FETCH_ASSOC);

        if($respProviderId){
            $cmdAvgCount = $this->con->query("
                select count(nota_comentario) as quantity, nota_media_usuario from comentarios, servicos, usuarios
                where comentarios.id_servico = servicos.id_servico and 
                servicos.id_prestador_servico = usuarios.id_usuario and usuarios.id_usuario = {$respProviderId['id_prestador_servico']} and 
                status_usuario =1 ;
            ");

            $dataAvgCount = $cmdAvgCount->fetch(PDO::FETCH_ASSOC);
            if($dataAvgCount){
                $response['provider']['rateQuantity'] = $dataAvgCount['quantity'];
                $response['provider']['averageRate'] = $dataAvgCount['nota_media_usuario'];
            }
        }

        $cmdServiceAvgQuantity = $this->con->query("
        select count(*) as quantity, servicos.nota_media_servico from comentarios, servicos
        where comentarios.id_servico = servicos.id_servico and servicos.id_servico = {$this->serviceID};
        ");

        $dataServiceCountAvg = $cmdServiceAvgQuantity->fetch(PDO::FETCH_ASSOC);
        if($dataServiceCountAvg){
            $response['service']['rateQuantity'] = $dataServiceCountAvg['quantity'];
            $response['service']['averageRate'] = $dataServiceCountAvg['nota_media_servico'];
        }

        return $response; // retone o array
    }

    private function refreshAverageRate ($serviceID){ // parei aqui senhor inácio. vc mesmo!!!!
    /*  Esta funcao calcula a media da nota do servico, e a media da nota do prestador.
        Portanto, ela deve ser chamada todas as vezes que um novo comentario ou avaliacao
        for inserido.
        Ela NAO insere uma nova nota no bd, ela SOMENTE ATUALIZA OS DADOS QUE JA ESTAO LA.
        Isto eh, esla pega as notas dos comentarios e atualiza o campo de nota media.

        Recebe: um id de servico para analisar.

        Ela retorna um array com as infomacoes contidas na array '$response', que sao as informacoes
        atualizadas das medias, quantidade de availiacoes e a soma de todas elas.
    */
    
        $response = array( // array de reposta
            'provider' => array( // infos do provedor de servico
                'rateQuantity' => 0,
                'sumRate' => 0,
                'averageRate' => 0
            ),
            'service' => array(
                'rateQuantity' => 0,
                'sumRate' => 0,
                'averageRate' => 0
            ),
            'info' => array( // satus da funcoa
                'allRight' => false, // se deu tudo certo = true
                'finished' => false, // se terminou = true
                'updated' => false // se conseguiu atualizar o bd = true.
            )
        );

        //este primeiro bloco, processara as notas do servico em si.
        $cmd = $this->con->query("SELECT nota_comentario FROM comentarios WHERE id_servico='$serviceID'"); // pegue todos os campos de comentarios desse servico e extraia a nota de cada um
        if($cmd->rowCount() > 0 && $cmd){ // caso exista ao mesnos 1 comentario.
            $serviceRates = $cmd->fetchAll(PDO::FETCH_ASSOC); // armazene as notas dos coentarios desse servico
            $response['service']['rateQuantity'] = $cmd->rowCount(); // prencha a resposta com a quantidade de avaliacoes que tem nesse servico.

            foreach ($serviceRates as $key => $rate) { // para cada nota ...
                $response['service']['sumRate'] += $rate['nota_comentario']; // ... adicone na soma de notas no array de resposta
            }

            $response['service']['averageRate'] = $response['service']['sumRate'] / $response['service']['rateQuantity']; // calcula a media do servico em si, e coloca no array de respostas
        }

        // esse segundo bloco de codigo processara todas as avaliacoes de todos os servico do prestador, e atualizara a sua media de prestador.
        $cmdProvider = $this->con->query("SELECT id_prestador_servico FROM servicos WHERE id_servico='$serviceID'"); // ache o ID do prestador, a fim de buscar todos os seus servicos
        if($cmdProvider->rowCount() > 0){ // caso exista esse ID do prestador
            $providerID = $cmdProvider->fetch(PDO::FETCH_ASSOC)['id_prestador_servico']; // extraia o ID. (3)

            $cmdAllServicesID = $this->con->query("SELECT id_servico FROM servicos WHERE id_prestador_servico='$providerID'"); // busque todos os IDs de servico, cujo o prestador seja o que acahamos
            if($cmdAllServicesID->rowCount() > 0 && $cmdAllServicesID){ // verificando se a bsca deu certo.
                $servicesID_data = $cmdAllServicesID->fetchAll(PDO::FETCH_ASSOC); // extaria todos os IDs de servico que estajam vinculados com esse prestador
                // (1, 4)
                foreach ($servicesID_data as $key => $serv) { // para cada servico desse prestador ...
                    $serv = $serv['id_servico']; // id do servico em analise

                    $cmd_thisServiceComments = $this->con->query("SELECT nota_comentario FROM comentarios WHERE id_servico='$serv'"); // busque a nota que esta nos comentarios desse servico em analise
                    if($cmd_thisServiceComments->rowCount() > 0){ // se existirem comentarios nesse servioc em analise
                        $data_commentsRate = $cmd_thisServiceComments->fetchAll(PDO::FETCH_ASSOC); // extraia todas as notas dos comentarios

                        $response['provider']['rateQuantity'] += $cmd_thisServiceComments->rowCount(); // adicone no array de repostas a quantidade de comentarios desse servico em analise somada com outros sericos que ja foram analisados

                        foreach ($data_commentsRate as $key => $commentRate) { // para cada nota desse servico em analise
                            $commentRate = $commentRate['nota_comentario']; // extarai a nota individual
                            $response['provider']['sumRate'] += $commentRate; // adicona essa nota no array de repostas, somando com as outras notas 
                        }

                    }
                }

                if($response['provider']['rateQuantity'] > 0){ // verificacao para nao existir divisao por zero
                    $response['provider']['averageRate'] = $response['provider']['sumRate'] / $response['provider']['rateQuantity']; // calcula a media do provider e coloca no array de repostas 
                }
                
            }
        }

        $cmd_updateProviderRate = $this->con->prepare("UPDATE usuarios SET nota_media_usuario=:average where id_usuario='$providerID';");
        $cmd_updateProviderRate->bindValue('average', $response['provider']['averageRate']);
        $providerUpadated = $cmd_updateProviderRate->execute();

        $cmd_updateServiceRate = $this->con->prepare("UPDATE servicos SET nota_media_servico=:average where id_servico='$serviceID';");
        $cmd_updateServiceRate->bindValue('average', $response['service']['averageRate']);
        $serviceUpadated = $cmd_updateServiceRate->execute();

        if($serviceUpadated){
            $response['info']['updated'] = true;
            $response['info']['allRight'] = true;
        }
        else{
            $response['info']['updated'] = false;
            $response['info']['allRight'] = false;
        }

        $response['info']['finished'] = true;
        return $response; // retone o array
    }

    public function setAvaliation($user_id, $userComment, $userRate){
        $response = array(
            'data' => '',
            'finished'=> false,
            'refreshAllComments' => false,
            'updatedAverage' => -1
        );

        $permition = $this->getAvaliationPermited();
        if($permition['status'] != 1){ // status 1 = aceito
            $response = false;
            //print_r($permition['status']);
        }
        else{
            
            $cmd = $this->con->query("INSERT INTO comentarios (id_servico, nota_comentario, desc_comentario, id_usuario) Values (
                '$this->serviceID', 
                '$userRate', 
                '$userComment',
                '$user_id'
                )");
            if($cmd){
                /*$cmdComment = $this->con->query("SELECT nota_comentario FROM comentarios WHERE id_servico='$this->serviceID'");
                $rateSum = 0;
                $commentQuantity = $cmdComment->rowCount();
                if($commentQuantity > 0){
                    $rateData = $cmdComment->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rateData as $key => $value) {
                        $rateSum = $rateSum + $value['nota'];
                    }
                }  
                else{
                    $commentQuantity = 1;
                }

                $serviceAvarage = $rateSum / $commentQuantity;
                
                $cmdServiceRate = $this->con->query("UPDATE servicos SET nota_media_servico='$serviceAvarage' WHERE id_servico='$this->serviceID'");
                if($cmdServiceRate){
                    $response['serviceAverage'] = $serviceAvarage;
                }*/
               // print_r($this->refreshAverageRate(0, $this->serviceID));
                $response['updatedAverage'] = $this->refreshAverageRate($this->serviceID);

                $response['data'] = $this->getComments();
                $response['finished'] = true;
                $response['refreshAllComments'] = true;
            }
            else{
                $response['finished'] = false;
                $response['error'] = "failed to insert data on server!";
            }
            
        }

        return $response;
    }

    public function getSelfService(){
        if(isset($_SESSION['idUsuario']) && isset($_SESSION['serviceID'])){
            $clientID = $_SESSION['idUsuario'];
            $serviceID = $_SESSION['serviceID'];

            $selfService = false;

            $cmd = $this->con->query("select id_servico from servicos where id_prestador_servico={$clientID} and id_servico={$serviceID};");
            if($cmd->rowCount() > 0){
                $selfService = true;
            }

            return $selfService;
        }

    }

    public function getOtherService($config){

        $response = array(
            "data" => array(),
            "info" => array(
                "allRight" => false,
            ),
            "config" => $config
        );

        $cmdCategories = $this->con->query("SELECT id_categoria FROM servico_categorias Where id_servico='$this->serviceID'");
        if($cmdCategories->rowCount() > 0){
            $catgorieID = $cmdCategories->fetch(PDO::FETCH_ASSOC)['id_categoria'];

            $cmdServices = $this->con->query("SELECT DISTINCT id_servico from servico_categorias where id_categoria='$catgorieID' LIMIT $config->quantity OFFSET $config->offset");
            if($cmdServices->rowCount() > 0){
                $servicesID = $cmdServices->fetchAll(PDO::FETCH_ASSOC);

                foreach ($servicesID as $key => $idSer) { // para cada id, busque as informacoes do servico em analise
                    $cmdThisService = $this->con->prepare("SELECT id_servico, nota_media_servico, id_prestador_servico, nome_servico, crit_orcamento_servico, orcamento_servico From servicos where id_servico=:idSer");
                    $cmdThisService->bindValue('idSer', $idSer['id_servico']);
                    $cmdThisService->execute();

                    if($cmdThisService->rowCount() > 0){
                        $response['data'][$key]['service'] = $cmdThisService->fetchAll(PDO::FETCH_ASSOC);
                        $response['data'][$key]['service'] = $response['data'][$key]['service'][0];

                        $cmdUserData = $this->con->prepare("SELECT nome_usuario, sobrenome_usuario, cidade_usuario, imagem_usuario FROM usuarios where id_usuario=:userID");
                        $cmdUserData->bindValue("userID", $response['data'][$key]['service']['id_prestador_servico']);
                        $cmdUserData->execute();

                        if($cmdUserData->rowCount() > 0){
                            $userData = $cmdUserData->fetchAll(PDO::FETCH_ASSOC);
                            $response['data'][$key]['user'] = $userData;
                            $response['data'][$key]['user'] = $response['data'][$key]['user'][0];

                            $response['info']['allRight'] = true;
                        }
                        else{
                            $response['info']['allRight'] = false;
                            $response['info']['error'] = "there is no user with this service: ". $idSer['id_servico'];
                        }
                    }
                }
            }
            else{
                $response['info']['allRight'] = false;
                $response['info']['error'] = "there is no service with this categorie";
            }
        }
        else{
            $response['info']['allRight'] = false;
            $response['info']['error'] = "categorie doesn't exist";
        }

        return $response;

    }

    public function getSaveService($userID){
        $cmdVerifyExists = $this->con->query("SELECT id_servico_salvo FROM servicos_salvos WHERE id_servico='$this->serviceID' and id_usuario='$userID'");

        return ($cmdVerifyExists->rowCount() > 0 ? true : false);
    }

    public function setSaveService($userID){
        $response = array(
            'allRight' => false,
            'inserted' => false,
            'deleted' => false
        );

        $cmdVerifyExists = $this->getSaveService($userID);

        if(!$cmdVerifyExists){
            $cmdSave = $this->con->query("INSERT INTO servicos_salvos (id_servico, id_usuario) Values('$this->serviceID', '$userID');");
            if($cmdSave){
                $response['allRight'] = true;
                $response['inserted'] = true;
    
            }
        }
        else{
            $cmdSave = $this->con->query("DELETE FROM servicos_salvos WHERE id_servico='$this->serviceID' and id_usuario='$userID';");
            if($cmdSave){
                $response['allRight'] = true;
                $response['deleted'] = true;
    
            }
            $response['allRight'] = true;
        }

        return $response;
    }
  
}