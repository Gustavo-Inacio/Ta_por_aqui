<?php
require 'DbConnection.php';

class editService
{
    private $con;
    private $serviceID;

    public function __construct($serviceID){
        $connectClass = new DbConnection();
        $this->con = $connectClass->connect();

        $this->serviceID = $serviceID;
    }

    public function getAllCategories()
    {
        $cmd = $this->con->query("select * from categorias order by id_categoria;");
        if($cmd->rowCount() > 0){
            $categories = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            return $categories;
            
        }
    }
    public function getAllSubcategories()
    {
        $cmd = $this->con->query("select * from subcategorias;");
        if($cmd->rowCount() > 0){
            $categories = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            return $categories;
            
        }
    }
    public function getServiceData()
    {
        $cmd = $this->con->query("select nome_servico, tipo_servico, desc_servico, orcamento_servico, crit_orcamento_servico from servicos where id_servico={$this->serviceID}");
        if($cmd->rowCount() > 0){
            $data = array();
            $data['serviceData'] = $cmd->fetch(PDO::FETCH_ASSOC);
            
            $subcategoriesCMD = $this->con->query("select id_subcategoria from servico_categorias where id_servico={$this->serviceID};");
            if($subcategoriesCMD->rowCount() > 0){
                $data['subcategories'] = $subcategoriesCMD->fetchAll(PDO::FETCH_ASSOC);
            }

            $serviceImgCMD = $this->con->query("select * from servico_imagens where id_servico={$this->serviceID};");
            if($serviceImgCMD->rowCount() > 0){
                $data['serviceIMG'] = $serviceImgCMD->fetchAll(PDO::FETCH_ASSOC);
            }

            return $data;
        }
    }

    public function verifySelfService(){
        $cmd = $this->con->query("select id_servico from servicos where id_prestador_servico={$_SESSION['idUsuario']} and id_servico={$_SESSION['serviceID']};");
        $isMyService = false;

        if($cmd->rowCount() > 0){
            $isMyService = true;
        }
        
        return $isMyService;
    }

}
?>