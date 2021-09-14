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
            "status" => false
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

        // print_r($a);
        return $reponse;

    }


    public function getServices($dataServices){
        $quantity = $dataServices->quantity;
        $cat = $dataServices->subCat;

        $minDistance = $dataServices->minDist;
        $maxDistance = $dataServices->maxDist;
        $myLat = $dataServices->myLat;
        $myLng = $dataServices->myLng;

        $searchWords = $dataServices->searchWords;


        function queryData($con, $initialDistance, $myLat, $myLng, $maxDistance, $subcategories, $searchTitleWords, $limit, $idToExclude){
            $subcategorieConditions = "";
            $wordsConditions = "";
            $variableCondition = "";
            $conjunction = "";
            
            // print_r($subcategories);

            $excludeIdServiceQuery = "";
            foreach ($idToExclude as $key => $value) {  
    
                $excludeIdServiceQuery .= " and servicos.id_servico != ".$value;
            }

            if(count($subcategories) > 0){
                foreach ($subcategories as $key => $value) { // arruma uma string que sera inserida na query, referemte a bsuca por categorias, cada categoria deve ser informada por um campo no array
                    if(!$key == 0){
                        $subcategorieConditions .= " or ";
                    }
    
                    $subcategorieConditions .= "servico_categorias.id_subcategoria=". $value;
                }

                $variableCondition .= "(".$subcategorieConditions.")";
            }
            

            if(count($searchTitleWords) > 0){
                foreach ($searchTitleWords as $key => $value) { // arruma uma string para ser colocada na query, refente a busca por palavras soltas, cada palavra dese ser enviada num campo de array
                    if(!$key == 0){
                        $wordsConditions .= " or ";
                    }
    
                    $wordsConditions .= "servicos.nome_servico LIKE '%". $value . "%'";
                }

                if(! $variableCondition == ""){
                    $variableCondition .= " or ";
                }

                $variableCondition .= $wordsConditions;
            }

            if(count($searchTitleWords) > 0 || count($subcategories) > 0){
                $conjunction = " and "; 
            }

            $subcatQuery = "
                INNER JOIN servico_categorias
                ON (".$variableCondition.") ".$conjunction." servico_categorias.id_servico=servicos.id_servico
            ";
            // $subcatQuery = "
            //     INNER JOIN servico_categorias
            //     ON ((".$subcategorieConditions.") 
            //     or ".$wordsConditions.") and servico_categorias.id_servico=servicos.id_servico
            // ";
            
            // query qye fara toda a pesquisa baseada na distancia, subcategorias, e query de busca por palavras soltas nos titulos dos servicos
            $query = "
            SELECT usuarios.nome_usuario, usuarios.sobrenome_usuario, usuarios.uf_usuario, usuarios.cidade_usuario, usuarios.bairro_usuario, usuarios.imagem_usuario, usuarios.id_usuario,
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
            //  print_r($query);

    
            $command = $con->query($query);
            $data = $command->fetchAll(PDO::FETCH_ASSOC);

            $infoToReturn = array();

            foreach($data as $value){
                if(!isset($infoToReturn['id_servico'])){
                    $infoToReturn['id_servico'] = $value;
                    $subCateg = $infoToReturn['id_servico']['id_subcategoria'];
                    $infoToReturn['id_servico']['id_subcategoria'] = array($subCateg);
                }
                else{
                    $subCat = $value['id_subcategoria'];
                    array_push($infoToReturn['id_servico']['id_subcategoria'], $subCat);
                }

            }
    
            return $infoToReturn;
            // echo "<pre>";
            // print_r($data);
            // echo "<pre/>";
        }

        // $cat  = array(
        //     130
        // );

        // $searchWords = array(
            
        // );

        // $minDistance = -1;
        // $maxDistance = 10000000;
        // $myLat = -23.87669;
        // $myLng = -46.77125;

        $dataToReturn = array(
            "data" => array(),
            "statusInfo" => array(
                "ended" => false
            )
        );

        $distanceDelimiter = $minDistance;
        $registerMaxDistance = array(-1);
        while(count($dataToReturn['data']) < $quantity){ // tanta retornar a quantidade minima de valor requisitado
            $resp = queryData($this->con, $distanceDelimiter, $myLat, $myLng, $maxDistance, $cat, $searchWords, ($quantity - count($dataToReturn['data']) + 5), $registerMaxDistance);
            if(count($resp) == 0){ // se pesquisaou e nao existe mais nada
                $quantity = -1; // diminui a qauntity para vaoltar no while
                $dataToReturn['statusInfo']['ended'] = true; // coloca que chegou ao final 
            }

            foreach ($resp as $key => $value) { // para cada valor retornado (ja organizado a quantidade de resultados pela quary)
                array_push($dataToReturn['data'], $value); // inclui na array de resposta de dada

                if($value['distance'] > $distanceDelimiter){ // pega o maior valor de distancia para serutilizado no proximo loop do while
                    $distanceDelimiter = $value['distance'];
                    array_push($registerMaxDistance, $value['id_servico']);
                }
                else if($value['distance'] == $distanceDelimiter){
                    $distanceDelimiter = $value['distance'];
                    array_push($registerMaxDistance, $value['id_servico']);
                    // $registerMaxDistance = $value['id_servico'];
                }
            }

        }
       

        // return queryData($this->con, $minDistance, $myLat, $myLng, $maxDistance, $cat, $searchWords, 50);
        return $dataToReturn;
    }
}


?>