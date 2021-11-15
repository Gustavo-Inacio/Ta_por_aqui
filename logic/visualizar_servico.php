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

        $cmd_provider = $this->con->query("select id_prestador_servico from servicos where id_servico={$this->serviceID}");
        $data = $cmd_provider->fetch(PDO::FETCH_ASSOC);
        $this->providerID = $data['id_prestador_servico'];
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

            $command = $this->con->query("SELECT status_contrato, count(*) as quantity FROM contratos WHERE id_cliente='$clientID' AND id_servico='$serviceID'");
            $statusData = $command->fetch(PDO::FETCH_ASSOC);

            if($statusData['quantity'] > 0){ // verifica se existe um contrato entre o sevico e esse user
                
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

    public function getAvaliation(){ // pega a propria avalizacao
        $response = false;
        if(isset($_SESSION['idUsuario'])){
            $command = $this->con->query("SELECT nota_comentario, desc_comentario from comentarios where id_servico={$this->serviceID} 
            and id_usuario={$_SESSION['idUsuario']} and status_comentario=1;");

            $avaliation = $command->fetch(PDO::FETCH_ASSOC);
            if($avaliation){
                $response = $avaliation;
            }
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
    private function refreshAverageRate($serviceID){
    /*  Esta funcao calcula a media da nota do servico, e a media da nota do prestador.
        Portanto, ela deve ser chamada todas as vezes que um novo comentario ou avaliacao
        for inserido.
        Ela NAO insere uma nova nota no bd, ela SOMENTE ATUALIZA OS DADOS QUE JA ESTAO LA.
        Isto eh, esla pega as notas dos comentarios e atualiza o campo de nota media.

        Recebe: um id de servico para analisar.
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

        $cmd_getAvaAvg = $this->con->query("
            SELECT avg(comentarios.nota_comentario) as avg, count(*) as quantity from servicos 
            inner join comentarios 
            on servicos.id_servico = comentarios.id_servico and servicos.id_servico = {$serviceID} and comentarios.status_comentario=1;
        ");

        $getAavaAvgData = $cmd_getAvaAvg->fetch(PDO::FETCH_ASSOC);
        if($getAavaAvgData && $getAavaAvgData['quantity'] > 0){
            $cmd_updateAvaAvg = $this->con->query("UPDATE servicos SET servicos.nota_media_servico = {$getAavaAvgData['avg']} where id_servico={$serviceID}");
            if($cmd_updateAvaAvg){
                $response['updated'] = true;
            }
        }

        // pega a quantidade de avaliacoes e a media delas, relacionadas a esse perstador de servicos
        $cmd_getProviderAvg = $this->con->query("
            select avg(nota_comentario) as provider_avg, count(*) as provider_ava_quantity from usuarios 
            join servicos 
            on usuarios.id_usuario = servicos.id_prestador_servico and usuarios.status_usuario=1 and status_servico=1 
            and servicos.id_prestador_servico = {$this->providerID}
            join comentarios 
            on comentarios.id_servico = servicos.id_servico and comentarios.status_comentario = 1;
        ");

        $provider_avg_data = $cmd_getProviderAvg->fetch(PDO::FETCH_ASSOC);
        if($provider_avg_data){
            $cmd_update_providerAVG = $this->con->query("
                update usuarios set usuarios.nota_media_usuario = {$provider_avg_data['provider_avg']} where usuarios.id_usuario = {$this->providerID};
            ");

            if($cmd_update_providerAVG){
                $response['updated'] = true;
            }
        }
    }


    public function setAvaliation($userComment, $userRate){
        $response = array(
            'data' => '',
            'finished'=> false,
            'refreshAllComments' => false,
            'updatedAverage' => -1
        );

        $permition = $this->getAvaliationPermited();
        if($permition['status'] != 1 || !isset($_SESSION['idUsuario'])){
            $response = false;
        }
        else{
            $user_id = $_SESSION['idUsuario'];

            $verifyExistAvaliationCMD = $this->con->query("SELECT id_comentario from comentarios where id_usuario={$user_id} and id_servico={$this->serviceID};");
            $existAvaData = $verifyExistAvaliationCMD->fetch(PDO::FETCH_ASSOC);
            if($existAvaData){ // se ja existe uma avaliacao devemos atualizar
                $cmd_updateAvaliation = $this->con->query(
                    "update comentarios set nota_comentario ={$userRate}, desc_comentario ='{$userComment}', data_comentario = current_timestamp() where id_comentario = {$existAvaData['id_comentario']};"
                );
                if($cmd_updateAvaliation){
                    $response['finished'] = true;
                }
                else{
                    $response['finished'] = false;
                }
                
            }
            else{ // se nao existe uma avaliacao, devsmos inserir a avaaliacao
                $cmd = $this->con->query("INSERT INTO comentarios (id_servico, nota_comentario, desc_comentario, id_usuario) Values (
                    '$this->serviceID', 
                    '$userRate', 
                    '$userComment',
                    '$user_id'
                    )");

                if($cmd){
                    $response['finished'] = true;
                }
                else{
                    $response['finished'] = false;
                }
            }

            if($response['finished']){
                $this->refreshAverageRate($this->serviceID);
                $response['updatedAverage'] = $this->getServiceProviderAverage($this->serviceID);

                $response['data'] = $this->getComments();
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

            $cmd = $this->con->query("SELECT count(id_servico) as quantity from servicos where id_prestador_servico={$clientID} and id_servico={$serviceID};");
            $data = $cmd->fetch(PDO::FETCH_ASSOC);

            if($data['quantity'] > 0){
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

        $cmd_getCatid = $this->con->query("
            select id_categoria from servico_categorias where id_servico={$this->serviceID};
        ");

        $catId = $cmd_getCatid->fetch(PDO::FETCH_ASSOC);
        if($catId){

            if(!isset($config->limit)){
                $config->limit = 15;
            }

            $cmd_getOtherServices = $this->con->query(
                "
                Select usuarios.nome_usuario, usuarios.cidade_usuario, 
                servicos.nota_media_servico, servicos.crit_orcamento_servico, servicos.nome_servico,
                servicos.orcamento_servico, usuarios.imagem_usuario, servicos.id_servico, servicos.tipo_servico
                from servicos
                inner join servico_categorias
                on servicos.id_servico = servico_categorias.id_servico and servico_categorias.id_categoria = {$catId['id_categoria']} and servicos.id_servico <> {$this->serviceID} and status_servico=1 
                inner join usuarios 
                on usuarios.id_usuario = servicos.id_prestador_servico and usuarios.status_usuario = 1
                group by id_servico limit {$config->limit};
                "
            );

            $other_services_data = $cmd_getOtherServices->fetchAll(PDO::FETCH_ASSOC);
            if($other_services_data){
                $dataToSend = array();
                foreach ($other_services_data as $key => $elem) { // verificacoes
                    $dataToSend[$key] = $elem;
                    if($elem['tipo_servico'] == 0){ // servico remoto - verifica se o servico eh remoto, se for, ele nem ena o nome da cidade
                        $dataToSend[$key]['cidade_usuario'] = "Serviço feito digitalmente";
                    }
                    
                }
                $response['info']['allRight'] = true;
                $response['data'] = $dataToSend;
            }
        }

        return $response;
    }

    public function getSaveService($userID){
        $cmdVerifyExists = $this->con->query("SELECT count(id_servico_salvo) as quantity FROM servicos_salvos WHERE id_servico='$this->serviceID' and id_usuario='$userID'");
        $data = $cmdVerifyExists->fetch(PDO::FETCH_ASSOC);

        return ($data['quantity'] > 0 ? true : false);
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