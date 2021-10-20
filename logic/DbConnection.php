<?php

class DbConnection {
    /*private $host = 'localhost';
    private $dbname = 'ta_por_aqui';
    private $user = 'root';
    private $password = '';*/
    private $host = 'sql10.freemysqlhosting.net';
    private $dbname = 'sql10444871';
    private $user = 'sql10444871';
    private $password = 'mQjzmpfgRa';

    public function connect(){
        //Iniciando conexão com o bd com PDO
        try{
            //remoto
            $connect = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;",
                "$this->user",
                "$this->password"
            );
            $connect->exec('SET CHARACTER SET utf8mb4');

            return $connect;

        } catch (PDOException $e){
            echo 'Não foi possivel se conectar com o servidor <br>';
            echo 'Código do erro: ' . $e->getCode() . '<br> Mensagem de erro: ' . $e->getMessage();
        }
    }
}