<?php

class DbConnection {
    private $host = 'sql205.epizy.com';
    private $dbname = 'epiz_28781284_ta_por_aqui';
    private $user = 'epiz_28781284';
    private $password = 'tpa13192528ftp';

    public function connect(){
        //Iniciando conexão com o bd com PDO
        try{
            $connect = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                "$this->user",
                "$this->password"
            );

            return $connect;

        } catch (PDOException $e){
            echo 'Não foi possivel se conectar com o servidor <br>';
            echo 'Código do erro: ' . $e->getCode() . '<br> Mensagem de erro: ' . $e->getMessage();
        }
    }

}
