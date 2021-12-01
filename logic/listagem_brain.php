<?php
require 'DbConnection.php';

class serviceList 
{
    private $con;
    public function __construct()
    {
        $connectClass = new DbConnection();
        $this->con = $connectClass->connect();
        $this->con->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8mb4_general_ci'");
    }

    public function getCatgorieInfo() {
        $reponse = array(
           
        );

        $query = "
        select categorias.nome_categoria, subcategorias.nome_subcategoria, categorias.id_categoria, subcategorias.id_subcategoria
        FROM categorias
        INNER JOIN subcategorias ON categorias.id_categoria = subcategorias.id_categoria order by categorias.id_categoria;";

        $cmd_getCategories = $this->con->query($query); // pesquisa todas as subcategorias (nome e ID) e as categorias (nome e ID)
        if($cmd_getCategories->rowCount() > 0){
            $categorie_sub = $cmd_getCategories->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categorie_sub as $key => $value) { // percorre todos os valores retornados do banco para organizar na resposta
                if(!isset($reponse[$value['id_categoria']])){ // caso nao estiver settado um campo no array de resposta para essa categoria em analise
                    $reponse[$value['id_categoria']] = array( // crie uma array com o titulo como nome da categoria no campo que relaciona o seu index com o ID do banco
                        "title" => $value['nome_categoria'],
                        "sub" => array()
                    );
                }

                $reponse[$value['id_categoria']]['sub'][$value['id_subcategoria']] = $value['nome_subcategoria'];  // adiciona a subcategoria dentro da sua correspondente de categoria entro do array. De forma que o sue index no arrayu tenha o mesmo codigo que o ID no bd.    
            }

            
        }

        $query = "SELECT * from categorias";
        $stmt = $this->con->query($query);
        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $reponse;
    }

    private function verifyPosition($con, $myLat, $myLng){ // verifica se a posicao informada é valida (para busca de servicos)

        if(!$myLat || !$myLng) { // caso nao existir
            if(isset($_SESSION['idUsuario'])){ // se estiver loggado, pega a localizacao do bd 
                $userID = $_SESSION['idUsuario'];
                $posCMD = $con->query("SELECT X(posicao_usuario) as lat, Y(posicao_usuario) as lng FROM usuarios where id_usuario=".$userID);
                $posData = $posCMD->fetch(PDO::FETCH_ASSOC); // localizacao do db
                if(count($posData) == 0){ // caso nao existir uma localizacao no bd, retone falso
                    return false;
                }
                else{
                    return $posData; // caso existir uma localizacao no bd e tiver resultados, retone-os
                }
            }
            else{
                return false; // se nap estiver loggado, nem com uma coordenada enviada, retorne falso
            }
        }
        else{ // caso tiver eviado uma coordenada, use-a.
            return array(
                "lat" => $myLat, 
                "lng" => $myLng
            );
        }
    }

    public function getNearServices($dataServices){
        $quantity = $dataServices->quantity; // quantidade de servicos a serem retornados nessa pacote
        $cat = $dataServices->subCat; // os codigos das subcategorias que foram selecionados la no front

        $minDistance = $dataServices->minDist; // a minima distancia a ser pesquisada
        $maxDistance = $dataServices->maxDist; //  a maxima distancia a ser pesquisada

        $myLat = $dataServices->myLat; // a latitude do user a ser verificada
        $myLng = $dataServices->myLng; // a lng do user a ser verificada

        $searchWords = $dataServices->searchWords; // as palavras que foram inseridas na busca escrita

        $dataToReturn = array();// array de daods de resposta

        // function verifyPosition($con, $myLat, $myLng){ // verifica se a posicao informada é valida

        //     if(!$myLat || !$myLng) { // caso nao existir
        //         if(isset($_SESSION['idUsuario'])){ // se estiver loggado, pega a localizacao do bd 
        //             $userID = $_SESSION['idUsuario'];
        //             $posCMD = $con->query("SELECT X(posicao_usuario) as lat, Y(posicao_usuario) as lng FROM usuarios where id_usuario=".$userID);
        //             $posData = $posCMD->fetch(PDO::FETCH_ASSOC); // localizacao do db
        //             if(count($posData) == 0){ // caso nao existir uma localizacao no bd, retone falso
        //                 return false;
        //             }
        //             else{
        //                 return $posData; // caso existir uma localizacao no bd e tiver resultados, retone-os
        //             }
        //         }
        //         else{
        //             return false; // se nap estiver loggado, nem com uma coordenada enviada, retorne falso
        //         }
        //     }
        //     else{ // caso tiver eviado uma coordenada, use-a.
        //         return array(
        //             "lat" => $myLat, 
        //             "lng" => $myLng
        //         );
        //     }
        // }

        $posResult = $this->verifyPosition($this->con, $myLat, $myLng); // resulatdo da verificacao de posicao

        if(!$posResult) { // se for falso, retone aqui mesmo a palicacao
            $dataToReturn['error'] = true; // erro de nao estar loggado
            return $dataToReturn;
        }
        else{ // caso estiver tudo ok, reestabeleca o valor nas variavies e contenue a vida
            $myLat = $posResult["lat"];
            $myLng = $posResult['lng'];
        }
 
        function queryNearServiceData($con, $initialDistance, $myLat, $myLng, $maxDistance, $subcategories, $searchTitleWords, $limit, $idToExclude){
            // nessa funcao a pesquisa e relaizada com base em todos os fatores
            $subcategorieConditions = "";
            $wordsConditions = "";
            $variableCondition = ""; // condicoes de subcategorias e de words
            $conjunction = "";
         
            $excludeIdServiceQuery = ""; // a pesquisa seguinte eh feita com base na distancia maior distancia da pesquisa anterior, e o service que antes estava incluido, agr nao pode ser repetido
            foreach ($idToExclude as $key => $value) {  // arruma um pedaco da query para os ids que serao escluidos
                $excludeIdServiceQuery .= " and servicos.id_servico != ".$value;
            }

            if(count($subcategories) > 0){ // se existirem subcategorias na pesquisa do user
                foreach ($subcategories as $key => $value) { // arruma uma string que sera inserida na query, referemte a bsuca por categorias, cada categoria deve ser informada por um campo no array
                    if(!$key == 0){
                        $subcategorieConditions .= " or ";
                    }
    
                    $subcategorieConditions .= "servico_categorias.id_subcategoria=". $value;
                }

                $variableCondition .= "(".$subcategorieConditions.")";
            }
            

            if(count($searchTitleWords) > 0){ // se existir pesquisa por palavras
                foreach ($searchTitleWords as $key => $value) { // arruma uma string para ser colocada na query, refente a busca por palavras soltas, cada palavra dese ser enviada num campo de array
                    if(!$key == 0){
                        $wordsConditions .= " or ";
                    }
    
                    $wordsConditions .= "servicos.nome_servico LIKE '%". $value . "%'";
                }

                if(! $variableCondition == ""){ // se nao exitir nada nessa variavel (podem existir as categorias ja)
                    $variableCondition .= " or ";
                }

                $variableCondition .= $wordsConditions;
            }

            if(count($searchTitleWords) > 0 || count($subcategories) > 0){ // se exstir alguma condicao
                $conjunction = " and "; // adicione a conjuncao and na query
            }

            $subcatQuery = "
                INNER JOIN servico_categorias
                ON (".$variableCondition.") ".$conjunction." servico_categorias.id_servico=servicos.id_servico
            "; // finaliza a query de condicoes
           
            // query qye fara toda a pesquisa baseada na distancia, subcategorias, e query de busca por palavras soltas nos titulos dos servicos
            $query = "
            SELECT usuarios.nome_usuario, usuarios.sobrenome_usuario, usuarios.uf_usuario, usuarios.cidade_usuario, usuarios.bairro_usuario, usuarios.imagem_usuario, usuarios.id_usuario, usuarios.mostrar_local_usuario,
            servicos.id_servico, servicos.nome_servico, servicos.orcamento_servico, servicos.crit_orcamento_servico, servicos.nota_media_servico, servicos.status_servico,
            ( 6371 * acos( cos( radians(".$myLat.") ) * cos( radians( X(usuarios.posicao_usuario) ) ) * cos( radians( Y(usuarios.posicao_usuario) ) - radians(".$myLng.") ) + sin( radians(".$myLat.") ) * sin(radians(X(posicao_usuario))) ) ) AS distance ,
            X(usuarios.posicao_usuario) as lat,
            Y(usuarios.posicao_usuario) as lng,
            servico_categorias.id_subcategoria

            FROM usuarios
            INNER JOIN servicos
            ON usuarios.id_usuario= servicos.id_prestador_servico ".$excludeIdServiceQuery."
            ".
            $subcatQuery.
            "
            HAVING distance>=".$initialDistance." and distance < ".$maxDistance." and servicos.status_servico=1
            ORDER BY distance
            LIMIT 0 , ".$limit.";
            ";
    
            $command = $con->query($query);
            $data = $command->fetchAll(PDO::FETCH_ASSOC);

            $infoToReturn = array();

            foreach($data as $value){ // caso um serico possuir 2 ou mais subcategorias que foram pesquisadas, ele fica repetido. Esse foreach cria somente um servico, e no local das subcategorias, coloca um array e junta todas elas no mesmo servico
                if(!isset($infoToReturn[$value['id_servico']])){ // caso ainda nao exitir esse servico no array
                    $infoToReturn[$value['id_servico']] = $value; // cria o servico e colca os dados
                    $subCateg = $infoToReturn[$value['id_servico']]['id_subcategoria']; // pega a subcategoria
                    $infoToReturn[$value['id_servico']]['id_subcategoria'] = array($subCateg); // cria um array no local de subcategoria e coloca a subcategoria no local
                }
                else{ // caso existir um campo no array com o mesmo id, significa que eh o mesmo servico, porem relacionado a uma outra subcategoria selecionada
                    $subCat = $value['id_subcategoria']; // pega essa subcategoria
                    array_push($infoToReturn[$value['id_servico']]['id_subcategoria'], $subCat); // add ela no array de subcategoria do servico
                }

            }

            return array(
                "data" => $infoToReturn,
                "info" => array(
                    "dataCount" => count($data),
                )
            );
          
        }

        $dataToReturn = array(
            "data" => array(),
            "statusInfo" => array(
                "ended" => false,
                "data->recived" => $dataServices
            )
        );

        $distanceDelimiter = $minDistance;
        $registerMaxDistance = $dataServices->service_idToExlucde;
        // print_r($dataServices);
        while(count($dataToReturn['data']) < $quantity){ // tanta retornar a quantidade minima de valor requisitado
            $resp = queryNearServiceData($this->con, $distanceDelimiter, $myLat, $myLng, $maxDistance, $cat, $searchWords, ($quantity - count($dataToReturn['data']) + 5), $registerMaxDistance);
            if((count($resp['data']) == 0) || $resp['info']['dataCount'] < ($quantity - count($dataToReturn['data']) + 5)){ // se pesquisaou e nao existe mais nada
                $quantity = -1; // diminui a qauntity para vaoltar no while
                $dataToReturn['statusInfo']['ended'] = true; // coloca que chegou ao final 
            }

            foreach ($resp['data'] as $key => $value) { // para cada valor retornado (ja organizado a quantidade de resultados pela quary)
                array_push($dataToReturn['data'], $value); // inclui na array de resposta de dada

                if($value['distance'] > $distanceDelimiter){ // pega o maior valor de distancia para serutilizado no proximo loop do while
                    $distanceDelimiter = $value['distance'];
                    // $registerMaxDistance = array($distanceDelimiter);
                    array_push($registerMaxDistance, $value['id_servico']);
                }
                else if($value['distance'] == $distanceDelimiter){
                    $distanceDelimiter = $value['distance'];
                    array_push($registerMaxDistance, $value['id_servico']);
                    // $registerMaxDistance = $value['id_servico'];
                }
            }

        }
       
        $dataToReturn['statusInfo']['maxDistance'] = $distanceDelimiter;
        return $dataToReturn;
    }

    public function getBestAvaServices($dataServices){
        $quantity = $dataServices->quantity; // quantidade de servicos a serem retornados nessa pacote
        $cat = $dataServices->subCat; // os codigos das subcategorias que foram selecionados la no front

        $minDistance = $dataServices->minDist; // a minima distancia a ser pesquisada
        $maxDistance = $dataServices->maxDist; //  a maxima distancia a ser pesquisada

        $myLat = $dataServices->myLat; // a latitude do user a ser verificada
        $myLng = $dataServices->myLng; // a lng do user a ser verificada

        $searchWords = $dataServices->searchWords; // as palavras que foram inseridas na busca escrita

        $dataToReturn = array();// array de daods de resposta

        // function verifyPosition($con, $myLat, $myLng){ // verifica se a posicao informada é valida

        //     if(!$myLat || !$myLng) { // caso nao existir
        //         if(isset($_SESSION['idUsuario'])){ // se estiver loggado, pega a localizacao do bd 
        //             $userID = $_SESSION['idUsuario'];
        //             $posCMD = $con->query("SELECT X(posicao_usuario) as lat, Y(posicao_usuario) as lng FROM usuarios where id_usuario=".$userID);
        //             $posData = $posCMD->fetch(PDO::FETCH_ASSOC); // localizacao do db
        //             if(count($posData) == 0){ // caso nao existir uma localizacao no bd, retone falso
        //                 return false;
        //             }
        //             else{
        //                 return $posData; // caso existir uma localizacao no bd e tiver resultados, retone-os
        //             }
        //         }
        //         else{
        //             return false; // se nap estiver loggado, nem com uma coordenada enviada, retorne falso
        //         }
        //     }
        //     else{ // caso tiver eviado uma coordenada, use-a.
        //         return array(
        //             "lat" => $myLat, 
        //             "lng" => $myLng
        //         );
        //     }
        // }

        $posResult = $this->verifyPosition($this->con, $myLat, $myLng); // resulatdo da verificacao de posicao

        if(!$posResult) { // se for falso, retone aqui mesmo a palicacao
            $dataToReturn['error'] = true; // erro de nao estar loggado
            return $dataToReturn;
        }
        else{ // caso estiver tudo ok, reestabeleca o valor nas variavies e contenue a vida
            $myLat = $posResult["lat"];
            $myLng = $posResult['lng'];
        }
 
        function queryBestAvaServices($con, $initialDistance, $myLat, $myLng, $maxDistance, $subcategories, $searchTitleWords, $limit, $idToExclude){
            // nessa funcao a pesquisa e relaizada com base em todos os fatores - ordena por avaliacoes em um certo raio de distancia
            $radius = "12742000"; // raio de pesquisa (valor equivalente a duas vezes o raio da terra em metros)
            $subcategorieConditions = "";
            $wordsConditions = "";
            $variableCondition = ""; // condicoes de subcategorias e de words
            $conjunction = "";
         
            $excludeIdServiceQuery = ""; // a pesquisa seguinte eh feita com base na distancia maior distancia da pesquisa anterior, e o service que antes estava incluido, agr nao pode ser repetido
            foreach ($idToExclude as $key => $value) {  // arruma um pedaco da query para os ids que serao escluidos
                $excludeIdServiceQuery .= " and servicos.id_servico != ".$value;
            }

            if(count($subcategories) > 0){ // se existirem subcategorias na pesquisa do user
                foreach ($subcategories as $key => $value) { // arruma uma string que sera inserida na query, referemte a bsuca por categorias, cada categoria deve ser informada por um campo no array
                    if(!$key == 0){
                        $subcategorieConditions .= " or ";
                    }
    
                    $subcategorieConditions .= "servico_categorias.id_subcategoria=". $value;
                }

                $variableCondition .= "(".$subcategorieConditions.")";
            }
            

            if(count($searchTitleWords) > 0){ // se existir pesquisa por palavras
                foreach ($searchTitleWords as $key => $value) { // arruma uma string para ser colocada na query, refente a busca por palavras soltas, cada palavra dese ser enviada num campo de array
                    if(!$key == 0){
                        $wordsConditions .= " or ";
                    }
    
                    $wordsConditions .= "servicos.nome_servico LIKE '%". $value . "%'";
                }

                if(! $variableCondition == ""){ // se nao exitir nada nessa variavel (podem existir as categorias ja)
                    $variableCondition .= " or ";
                }

                $variableCondition .= $wordsConditions;
            }

            if(count($searchTitleWords) > 0 || count($subcategories) > 0){ // se exstir alguma condicao
                $conjunction = " and "; // adicione a conjuncao and na query
            }

            $subcatQuery = "
                INNER JOIN servico_categorias
                ON (".$variableCondition.") ". ' and ' ." servico_categorias.id_servico=servicos.id_servico
            "; // finaliza a query de condicoes
           
            // query qye fara toda a pesquisa baseada na distancia, subcategorias, e query de busca por palavras soltas nos titulos dos servicos
            $query = "
            SELECT usuarios.nome_usuario, usuarios.sobrenome_usuario, usuarios.uf_usuario, usuarios.cidade_usuario, usuarios.bairro_usuario, usuarios.imagem_usuario, usuarios.id_usuario, usuarios.mostrar_local_usuario,
            servicos.id_servico, servicos.nome_servico, servicos.orcamento_servico, servicos.crit_orcamento_servico, servicos.nota_media_servico, servicos.status_servico,
            ( 6371 * acos( cos( radians(".$myLat.") ) * cos( radians( X(usuarios.posicao_usuario) ) ) * cos( radians( Y(usuarios.posicao_usuario) ) - radians(".$myLng.") ) + sin( radians(".$myLat.") ) * sin(radians(X(posicao_usuario))) ) ) AS distance ,
            X(usuarios.posicao_usuario) as lat,
            Y(usuarios.posicao_usuario) as lng,
            servico_categorias.id_subcategoria

            FROM usuarios
            INNER JOIN servicos
            ON usuarios.id_usuario= servicos.id_prestador_servico ".$excludeIdServiceQuery."
            ".
            $subcatQuery.
            "
            HAVING distance>=".$initialDistance." and distance < ".$radius." and servicos.status_servico=1
            ORDER BY servicos.nota_media_servico desc
            ";
            //  print_r($query);

    
            $command = $con->query($query);
            $data = $command->fetchAll(PDO::FETCH_ASSOC);

            $infoToReturn = array();

            foreach($data as $value){ // caso um serico possuir 2 ou mais subcategorias que foram pesquisadas, ele fica repetido. Esse foreach cria somente um servico, e no local das subcategorias, coloca um array e junta todas elas no mesmo servico
                if(!isset($infoToReturn[$value['id_servico']])){ // caso ainda nao exitir esse servico no array
                    $infoToReturn[$value['id_servico']] = $value; // cria o servico e colca os dados
                    $subCateg = $infoToReturn[$value['id_servico']]['id_subcategoria']; // pega a subcategoria
                    $infoToReturn[$value['id_servico']]['id_subcategoria'] = array($subCateg); // cria um array no local de subcategoria e coloca a subcategoria no local
                }
                else{ // caso existir um campo no array com o mesmo id, significa que eh o mesmo servico, porem relacionado a uma outra subcategoria selecionada
                    $subCat = $value['id_subcategoria']; // pega essa subcategoria
                    array_push($infoToReturn[$value['id_servico']]['id_subcategoria'], $subCat); // add ela no array de subcategoria do servico
                }

            }

            return array(
                "data" => $infoToReturn,
                "info" => array(
                    "dataCount" => count($data),
                )
            );
          
        }

        $dataToReturn = array(
            "data" => array(),
            "statusInfo" => array(
                "ended" => false,
                "data->recived" => $dataServices
            )
        );

        $distanceDelimiter = $minDistance;
        $registerMaxDistance = $dataServices->service_idToExlucde;
        // print_r($dataServices);
        while(count($dataToReturn['data']) < $quantity){ // tanta retornar a quantidade minima de valor requisitado
            $resp = queryBestAvaServices($this->con, $distanceDelimiter, $myLat, $myLng, $maxDistance, $cat, $searchWords, ($quantity - count($dataToReturn['data']) + 5), $registerMaxDistance);
            if((count($resp['data']) == 0) || $resp['info']['dataCount'] < ($quantity - count($dataToReturn['data']) + 5)){ // se pesquisaou e nao existe mais nada
                $quantity = -1; // diminui a qauntity para vaoltar no while
                $dataToReturn['statusInfo']['ended'] = true; // coloca que chegou ao final 
            }

            foreach ($resp['data'] as $key => $value) { // para cada valor retornado (ja organizado a quantidade de resultados pela quary)
                array_push($dataToReturn['data'], $value); // inclui na array de resposta de dada

                if($value['distance'] > $distanceDelimiter){ // pega o maior valor de distancia para serutilizado no proximo loop do while
                    $distanceDelimiter = $value['distance'];
                    // $registerMaxDistance = array($distanceDelimiter);
                    array_push($registerMaxDistance, $value['id_servico']);
                }
                else if($value['distance'] == $distanceDelimiter){
                    $distanceDelimiter = $value['distance'];
                    array_push($registerMaxDistance, $value['id_servico']);
                    // $registerMaxDistance = $value['id_servico'];
                }
            }

        }
       
        $dataToReturn['statusInfo']['maxDistance'] = $distanceDelimiter;
        return $dataToReturn;
    }


    public function getServices($dataServices){
        // const config = { // configuracoes de requisicao
        //     getServices: true,
        //     dataServices: {
        //         bestAvaliation: true,
        //         quantity : 1,
        //         maxDist: 10000,
        //         minDist: servicesSate.lastDistance,
        //         myLat: -23.87669,
        //         myLng: -46.77125,
        //         subCat: subCatid,
        //         searchWords: searachState.write,
        //         service_idToExlucde : servicesSate.service_idToExlucde || []
        //     }
            
        // };

        if(isset($dataServices->bestAvaliation) && $dataServices->bestAvaliation == 'true'){
            return $this->getBestAvaServices($dataServices);
        }
        else{
            return $this->getNearServices($dataServices);
        }

        
    }


}
?>