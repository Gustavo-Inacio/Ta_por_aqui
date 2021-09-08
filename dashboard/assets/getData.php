<?php
class DbConnection {
    private $host = 'sql10.freemysqlhosting.net';
    private $dbname = 'sql10435599';
    private $user = 'sql10435599';
    private $password = 'buc8h6VbjS';

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
            exit();
        }
    }
}

class AnalisysChartData {
    //conexão
    private $con;

    //Estatísticas de usuários
    private $totalUsers;
    private $providers;
    private $clients;
    private $women;
    private $men;
    private $otherSex;

    //Estatísticas de Serviços
    private $totalServices;
    private $presencialServices;
    private $remoteServices;
    private $bannedServices;
    private $viewsAverage;
    private $ratingAverage;

    //Estatísticas de contrato
    private $totalContracts;
    private $pendingContracts;
    private $acceptContracts;
    private $rejectedContracts;

    //Contruir dados
    public function __construct($year) {
        //conectar com o banco
        $this->con = new DbConnection();
        $this->con = $this->con->connect();

        $extraUserParam = '';
        $extraServiceParam = '';
        $extraContractParam = '';
        if ($year === ""){
            $extraUserParam = 1;
            $extraServiceParam = 1;
            $extraContractParam = 1;
        } else {
            $extraUserParam = "YEAR(data_entrada_usuario) = $year";
            $extraServiceParam = "YEAR(data_public_servico) = $year";
            $extraContractParam = "YEAR(data_contrato) = $year";
        }

        //construir estatísticas dos usuários
        $query = "SELECT count(id_usuario) as users from usuarios WHERE $extraUserParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->totalUsers = $result->users;

        $query = "SELECT count(id_usuario) as providers from usuarios WHERE classif_usuario IN(1,2) AND $extraUserParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->providers = $result->providers;

        $query = "SELECT count(id_usuario) as clients from usuarios WHERE classif_usuario = 0 AND $extraUserParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->clients = $result->clients;

        $query = "SELECT count(id_usuario) as women from usuarios WHERE sexo_usuario = 'F' AND $extraUserParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->women = $result->women;

        $query = "SELECT count(id_usuario) as men from usuarios WHERE sexo_usuario = 'M' AND $extraUserParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->men = $result->men;

        $query = "SELECT count(id_usuario) as otherSex from usuarios WHERE sexo_usuario = 'O' AND $extraUserParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->otherSex = $result->otherSex;

        //construir estatísticas dos serviços
        $query = "SELECT count(id_servico) as servicos from servicos WHERE $extraServiceParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->totalServices = $result->servicos;

        $query = "SELECT count(id_servico) as presencial from servicos WHERE tipo_servico = 1 AND $extraServiceParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->presencialServices = $result->presencial;

        $query = "SELECT count(id_servico) as remote from servicos WHERE tipo_servico = 0 AND $extraServiceParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->remoteServices = $result->remote;

        $query = "SELECT count(id_servico) as banned from servicos WHERE status_servico = 2 AND $extraServiceParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->bannedServices = $result->banned;

        $query = "SELECT avg(qnt_visualizacoes_servico) as views from servicos WHERE $extraServiceParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->viewsAverage = round($result->views, 1);

        $query = "SELECT avg(nota_media_servico) as rate from servicos WHERE $extraServiceParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->ratingAverage = round($result->rate, 1);

        //construir estatísticas dos contratos
        $query = "SELECT count(id_contrato) as contratos from contratos WHERE $extraContractParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->totalContracts = $result->contratos;

        $query = "SELECT count(id_contrato) as pending from contratos WHERE status_contrato = 0 AND $extraContractParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->pendingContracts = $result->pending;

        $query = "SELECT count(id_contrato) as accept from contratos WHERE status_contrato = 1 AND $extraContractParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->acceptContracts = $result->accept;

        $query = "SELECT count(id_contrato) as rejected from contratos WHERE status_contrato = 2 AND $extraContractParam";
        $stmt = $this->con->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->rejectedContracts = $result->rejected;
    }

    //retornar valores desse objeto: estatísticas dos usuários, serviços e contratos
    public function __get($attr){
        return $this->$attr;
    }

    //Buscar serviços mais populares
    public function getMostPopularServices($year){
        $extraParam = "";
        if ($year === ""){
            $extraParam = 1;
        } else {
            $extraParam = "YEAR(c.data_contrato) = $year";
        }

        $query = "SELECT count(c.id_servico) as qntContratos, s.nome_servico FROM contratos as c JOIN servicos as s on c.id_servico = s.id_servico WHERE $extraParam GROUP BY c.id_servico ORDER BY count(c.id_servico) DESC LIMIT 0,5";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar categorias mais escolhidas
    public function getMostChosenCategories($year){
        $extraParam = "";
        if ($year === ""){
            $extraParam = 1;
        } else {
            $extraParam = "YEAR(s.data_public_servico) = $year";
        }

        $query = "SELECT count(sc.id_categoria) as qntEscolhas, c.nome_categoria FROM servico_categorias as sc JOIN categorias as c on sc.id_categoria = c.id_categoria join servicos as s on s.id_servico = sc.id_servico WHERE $extraParam GROUP BY sc.id_categoria ORDER BY count(sc.id_categoria) DESC LIMIT 0,5";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar motivos comuns de saída do usuário
    public function getMostCommonUserExit($year){
        $extraParam = "";
        if ($year === ""){
            $extraParam = 1;
        } else {
            $extraParam = "YEAR(msu.data_del_conta) = $year";
        }

        $query = "SELECT count(msu.id_del_motivo) as qntEscolhas, dcm.del_motivo FROM motivos_saida_usuario as msu JOIN deletar_conta_motivos as dcm on msu.id_del_motivo = dcm.id_del_motivo WHERE $extraParam GROUP BY msu.id_del_motivo ORDER BY count(msu.id_del_motivo) DESC LIMIT 0,5";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar motivos mais comuns de denúncias de serviço
    public function getMostCommonServComplains($year){
        $extraParam = "";
        if ($year === ""){
            $extraParam = 1;
        } else {
            $extraParam = "YEAR(ds.data_denuncia_serv) = $year";
        }

        $query = "SELECT count(ds.id_denuncia_motivo) as qntDenuncias, dm.denuncia_motivo FROM denuncia_servico as ds JOIN denuncia_motivo as dm on ds.id_denuncia_motivo = dm.id_denuncia_motivo WHERE dm.categoria_motivo = 1 AND $extraParam GROUP BY ds.id_denuncia_motivo ORDER BY count(ds.id_denuncia_motivo) DESC LIMIT 0,5";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar motivos mais comuns de denúncias de comentário
    public function getMostCommonComenComplains($year){
        $extraParam = "";
        if ($year === ""){
            $extraParam = 1;
        } else {
            $extraParam = "YEAR(dc.data_denuncia_comen) = $year";
        }

        $query = "SELECT count(dc.id_denuncia_motivo) as qntDenuncias, dm.denuncia_motivo FROM denuncia_comentario as dc JOIN denuncia_motivo as dm on dc.id_denuncia_motivo = dm.id_denuncia_motivo WHERE dm.categoria_motivo = 2 AND $extraParam GROUP BY dc.id_denuncia_motivo ORDER BY count(dc.id_denuncia_motivo) DESC LIMIT 0,5";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar motivos de contato
    public function getContactReason($year){
        $extraParam = "";
        $results = [
            'elogios' => "",
            'sugestoes' => "",
            'reclamacoes' => "",
            'bugs' => "",
            'outros' => ""
        ];

        if ($year === ""){
            $extraParam = 1;
        } else {
            $extraParam = "YEAR(data_contato) = $year";
        }

        $stmt = $this->con->query("SELECT count(id_contato) as elogios from fale_conosco WHERE motivo_contato = 1 AND $extraParam");
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);
        $results['elogios'] = $tmp['elogios'];

        $stmt = $this->con->query("SELECT count(id_contato) as sugestoes from fale_conosco WHERE motivo_contato = 2 AND $extraParam");
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);
        $results['sugestoes'] = $tmp['sugestoes'];

        $stmt = $this->con->query("SELECT count(id_contato) as reclamacoes from fale_conosco WHERE motivo_contato = 3 AND $extraParam");
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);
        $results['reclamacoes'] = $tmp['reclamacoes'];

        $stmt = $this->con->query("SELECT count(id_contato) as bugs from fale_conosco WHERE motivo_contato = 4 AND $extraParam");
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);
        $results['bugs'] = $tmp['bugs'];

        $stmt = $this->con->query("SELECT count(id_contato) as outros from fale_conosco WHERE motivo_contato = 5 AND $extraParam");
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);
        $results['outros'] = $tmp['outros'];

        return $results;
    }
}

class UsersListing {
    private $con;

    public function __construct(){
        //conectar com o banco
        $this->con = new DbConnection();
        $this->con = $this->con->connect();
    }

    public function selectAllUsers(){
        $query = "SELECT id_usuario, nome_usuario, classif_usuario, email_usuario, nota_media_usuario, status_usuario, imagem_usuario from usuarios";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectFilteredUsers($status, $classificacao){
        $extraParam = "";
        if ($status === "" && $classificacao !== ""){
            $extraParam = "WHERE classif_usuario = " . intval($classificacao);
        } else if ($status !== "" && $classificacao === ""){
            $extraParam = "WHERE status_usuario = " . intval($status);
        } else if ($status !== "" && $classificacao !== ""){
            $extraParam = "WHERE status_usuario = " . intval($status) . " AND classif_usuario = " . intval($classificacao);
        }
        $query = "SELECT id_usuario, nome_usuario, classif_usuario, email_usuario, nota_media_usuario, status_usuario, imagem_usuario from usuarios $extraParam";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSearchedUsers($input, $param){
        $query = "SELECT id_usuario, nome_usuario, classif_usuario, email_usuario, nota_media_usuario, status_usuario, imagem_usuario from usuarios WHERE $param like '$input%'";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}