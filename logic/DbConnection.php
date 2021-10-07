<?php

class DbConnection {
    private $host = 'localhost';
    private $dbname = 'ta_por_aqui';
    private $user = 'root';
    private $password = '';

    public function connect(){
        //Iniciando conexão com o bd com PDO
        try{
            $connect = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                "$this->user",
                "$this->password"
            );

            // $connect->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");

            return $connect;

        } catch (PDOException $e){
            echo 'Não foi possivel se conectar com o servidor <br>';
            echo 'Código do erro: ' . $e->getCode() . '<br> Mensagem de erro: ' . $e->getMessage();
        }
    }
}