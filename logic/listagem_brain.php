<?php
require 'DbConnection.php';

class serviceList 
{
    private $con;
    public function __construct()
    {
        $connectClass = new DbConnection();
        $this->con = $connectClass->connect();
    }

    public function getCatgorieInfo() {
        $reponse = array();

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

            return $reponse;
        }


    }
}


?>