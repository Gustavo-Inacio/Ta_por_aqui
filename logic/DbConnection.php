<?php

class DbConnection {
    // private $host = 'localhost';
    // private $dbname = 'ta_por_aqui';
    // private $user = 'root';
    // private $password = '';
    private $host = 'sql10.freemysqlhosting.net';
    private $dbname = 'sql10443065';
    private $user = 'sql10443065';
    private $password = 'v1G7Ciq2ne';

    // Server: sql10.freemysqlhosting.net
    // Name: sql10443065
    // Username: sql10443065
    // Password: v1G7Ciq2ne
    // Port number: 3306

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