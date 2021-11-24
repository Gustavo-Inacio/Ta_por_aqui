<?php
//importando o código para envio de eventuais emails
@include '../../assets/phpMailer/Exception.php';
@include '../../assets/phpMailer/OAuth.php';
@include '../../assets/phpMailer/PHPMailer.php';
@include '../../assets/phpMailer/POP3.php';
@include '../../assets/phpMailer/SMTP.php';

//usando os namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DashboardConnection {
    //private $host = 'sql10.freemysqlhosting.net';
    //private $dbname = 'sql10451316';
    //private $user = 'sql10451316';
    //private $password = '4NI3kwvRbS';

    private $host = 'localhost';
    private $dbname = 'ta_por_aqui';
    private $user = 'root';
    private $password = '';

    public function connect(){
        //Iniciando conexão com o bd com PDO
        try{
            $connect = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;",
                "$this->user",
                "$this->password"
            );
            $connect->exec('SET CHARACTER SET utf8');

            return $connect;

        } catch (PDOException $e){
            echo 'Não foi possivel se conectar com o servidor <br>';
            echo 'Código do erro: ' . $e->getCode() . '<br> Mensagem de erro: ' . $e->getMessage();
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
        $this->con = new DashboardConnection();
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
            'outros' => "",
            'ban_contests' => ""
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

        $stmt = $this->con->query("SELECT count(id_contato) as ban_contests from fale_conosco WHERE motivo_contato = 6 AND $extraParam");
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);
        $results['ban_contests'] = $tmp['ban_contests'];

        return $results;
    }
}

class UsersListing {
    private $con;

    public function __construct(){
        //conectar com o banco
        $this->con = new DashboardConnection();
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

        $this->totalItens = $stmt->rowCount();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSearchedUsers($input, $param){
        $query = "SELECT id_usuario, nome_usuario, classif_usuario, email_usuario, nota_media_usuario, status_usuario, imagem_usuario from usuarios WHERE $param like '$input%'";
        $stmt = $this->con->query($query);

        $this->totalItens = $stmt->rowCount();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class ServicesListing {
    private $con;

    public function __construct(){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();
    }

    public function selectAllServices(){
        $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, s.tipo_servico, s.nota_media_servico, s.status_servico, u.id_usuario, u.nome_usuario from servicos as s join usuarios as u on s.id_prestador_servico = u.id_usuario left join denuncia_servico as ds on s.id_servico = ds.id_servico group by s.id_servico";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectFilteredServices($status, $complain){
        $query = "";
        if ($status !== "" && $complain === ""){
            $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, s.tipo_servico, s.nota_media_servico, s.status_servico, u.id_usuario, u.nome_usuario from servicos as s join usuarios as u on s.id_prestador_servico = u.id_usuario left join denuncia_servico as ds on s.id_servico = ds.id_servico WHERE s.status_servico = " . intval($status) . " group by s.id_servico";
        } else if ($status === "" && $complain !== ""){
            $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, s.tipo_servico, s.nota_media_servico, s.status_servico, u.id_usuario, u.nome_usuario from servicos as s join usuarios as u on s.id_prestador_servico = u.id_usuario right join denuncia_servico as ds on s.id_servico = ds.id_servico group by s.id_servico";
        } else if($status !== "" && $complain !== ""){
            $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, s.tipo_servico, s.nota_media_servico, s.status_servico, u.id_usuario, u.nome_usuario from servicos as s join usuarios as u on s.id_prestador_servico = u.id_usuario right join denuncia_servico as ds on s.id_servico = ds.id_servico WHERE s.status_servico = " . intval($status) . " group by s.id_servico";
        } else {
            $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, s.tipo_servico, s.nota_media_servico, s.status_servico, u.id_usuario, u.nome_usuario from servicos as s join usuarios as u on s.id_prestador_servico = u.id_usuario left join denuncia_servico as ds on s.id_servico = ds.id_servico group by s.id_servico";
        }

        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSearchedServices($input, $param){
        $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, s.tipo_servico, s.nota_media_servico, s.status_servico, u.id_usuario, u.nome_usuario from servicos as s join usuarios as u on s.id_prestador_servico = u.id_usuario left join denuncia_servico as ds on s.id_servico = ds.id_servico WHERE $param like '$input%' group by s.id_servico";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQntComplains($idServ){
        $query = "SELECT count(*) as denuncias from denuncia_servico where id_servico = $idServ";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['denuncias'];
    }
}

class CommentsListing {
    private $con;

    public function __construct(){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();
    }

    public function selectAllComments(){
        $query = "SELECT c.id_comentario, c.id_servico, c.id_usuario, c.desc_comentario, s.nome_servico, u.nome_usuario from comentarios as c join servicos as s on c.id_servico = s.id_servico join usuarios as u on c.id_usuario = u.id_usuario join denuncia_comentario dc on c.id_comentario = dc.id_comentario where (select count(*) from denuncia_comentario where dc.id_comentario AND dc.status_denuncia_comen != 2) > 0 group by c.id_comentario";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSearchedComments($input, $param){
        $query = "SELECT c.id_comentario, c.id_servico, c.id_usuario, c.desc_comentario, s.nome_servico, u.nome_usuario from comentarios as c join servicos as s on c.id_servico = s.id_servico join usuarios as u on c.id_usuario = u.id_usuario join denuncia_comentario dc on c.id_comentario = dc.id_comentario WHERE $param like '%$input%' AND (select count(*) from denuncia_comentario where dc.id_comentario AND dc.status_denuncia_comen != 2) > 0 group by c.id_comentario";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQntComplains($idCom){
        $query = "SELECT count(*) as denuncias from denuncia_comentario where id_comentario = $idCom AND status_denuncia_comen in(0,1)";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['denuncias'];
    }
}

class ContactListing {
    private $con;

    public function __construct(){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();
    }

    public function selectAllContacts(){
        $query = "SELECT id_contato, email_contato, msg_contato, motivo_contato FROM fale_conosco";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectFilteredContacts($reason, $status){
        $extraParam = "";
        if ($reason !== "" && $status === ""){
            $extraParam = "WHERE motivo_contato = $reason";
        } else if ($reason === "" && $status !== ""){
            $extraParam = "WHERE status_contato = $status";
        } else if ($reason !== "" && $status !== ""){
            $extraParam = "WHERE status_contato = $status AND motivo_contato = $reason";
        }
        $query = "SELECT id_contato, email_contato, msg_contato, motivo_contato FROM fale_conosco $extraParam";

        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSearchedContacts($input, $param){
        $query = "SELECT id_contato, email_contato, msg_contato, motivo_contato FROM fale_conosco WHERE $param like '$input%'";
        $stmt = $this->con->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class UserReport {
    private $con;
    public $id_usuario;

    public function __construct($id){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();

        $this->id_usuario = $id;
    }

    public function getUserInfo(){
        $query = "SELECT id_usuario, nome_usuario, sobrenome_usuario, fone_usuario, email_usuario, senha_usuario, data_nasc_usuario, sexo_usuario, classif_usuario, status_usuario, uf_usuario, cidade_usuario, data_nasc_usuario, data_entrada_usuario, imagem_usuario, nota_media_usuario, desc_usuario, email_contato_usuario FROM usuarios where id_usuario = $this->id_usuario";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserComments(){
        $query = "SELECT c.id_comentario, c.id_usuario, u.nome_usuario, c.id_servico, s.nome_servico, c.desc_comentario FROM comentarios c left join usuarios u on c.id_usuario = u.id_usuario left join servicos s on c.id_servico = s.id_servico where c.id_usuario = $this->id_usuario";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComComplains($idCom){
        $query = "SELECT count(*) as denuncias from denuncia_comentario where id_comentario = $idCom AND status_denuncia_comen in(0,1)";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['denuncias'];
    }

    public function getUserServices(){
        $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, u.nome_usuario, s.tipo_servico, s.nota_media_servico, s.status_servico from servicos s join usuarios u on s.id_prestador_servico = u.id_usuario where id_prestador_servico = $this->id_usuario";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServComplains($idServ){
        $query = "SELECT count(*) as denuncias from denuncia_servico where id_servico = $idServ";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['denuncias'];
    }

    public function banThisUser(){
        $query = "UPDATE usuarios SET status_usuario = 2 WHERE id_usuario = $this->id_usuario";
        $stmt = $this->con->query($query);

        $query = "UPDATE servicos SET status_servico = 2 WHERE id_prestador_servico = $this->id_usuario AND status_servico = 1";
        $stmt = $this->con->query($query);

        $query = "UPDATE comentarios SET status_comentario = 0 WHERE id_usuario = $this->id_usuario AND status_comentario = 1";
        $stmt = $this->con->query($query);
        return "Usuário, serviços e comentários banidos";
    }

    public function unbanThisUser(){
        $query = "UPDATE usuarios SET status_usuario = 1 WHERE id_usuario = $this->id_usuario";
        $stmt = $this->con->query($query);

        $query = "UPDATE servicos SET status_servico = 1 WHERE id_prestador_servico = $this->id_usuario AND status_servico = 2";
        $stmt = $this->con->query($query);

        $query = "UPDATE comentarios SET status_comentario = 1 WHERE id_usuario = $this->id_usuario AND status_comentario = 0";
        $stmt = $this->con->query($query);
        return "Usuário, serviços e comentários desbanidos";
    }
}

class CommentReport {
    private $con;
    public $id_comentario;

    public function __construct($id){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();

        $this->id_comentario = $id;
    }

    public function getCommentInfo(){
        $query = "SELECT c.id_comentario, c.id_usuario, u.nome_usuario, u.sobrenome_usuario, c.id_servico, s.nome_servico, c.nota_comentario, c.data_comentario, c.status_comentario, c.desc_comentario FROM comentarios c join usuarios u on c.id_usuario = u.id_usuario join servicos s on c.id_servico = s.id_servico where c.id_comentario = $this->id_comentario";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getComComplains($idCom){
        $query = "SELECT count(*) as denuncias from denuncia_comentario where id_comentario = $idCom AND status_denuncia_comen in(0,1)";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['denuncias'];
    }

    public function banThisComment(){
        $query = "UPDATE comentarios SET status_comentario = 0 WHERE id_comentario = $this->id_comentario";
        $stmt = $this->con->query($query);
        return "Comentário banido e ocultado do público";
    }

    public function unbunThisComment(){
        $query = "UPDATE comentarios SET status_comentario = 1 WHERE id_comentario = $this->id_comentario";
        $stmt = $this->con->query($query);
        return "Comentário desbanido e exibido ao público";
    }

    public function getConplainsToThisComment(){
        $query = "SELECT dc.id_denuncia_comentario, dc.id_denuncia_motivo, dm.denuncia_motivo, dc.id_usuario, u.nome_usuario, u.sobrenome_usuario, dc.desc_denuncia_comen, dc.data_denuncia_comen, dc.status_denuncia_comen FROM denuncia_comentario dc join usuarios u on dc.id_usuario = u.id_usuario join denuncia_motivo dm on dc.id_denuncia_motivo = dm.id_denuncia_motivo WHERE dc.status_denuncia_comen in(0,1)";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function changeComplainStatus($status, $id){
        $query = "UPDATE denuncia_comentario SET status_denuncia_comen = $status WHERE id_denuncia_comentario = $id";
        $stmt = $this->con->query($query);
        return "Status da denúncia alterado";
    }
}

class ServiceReport {
    private $con;
    public $id_servico;

    public function __construct($id){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();

        $this->id_servico = $id;
    }

    public function getServiceInfo(){
        $query = "SELECT s.id_servico, s.nome_servico, s.id_prestador_servico, u.nome_usuario, u.sobrenome_usuario, s.tipo_servico, s.desc_servico, s.orcamento_servico, s.crit_orcamento_servico, s.nota_media_servico, s.status_servico, s.data_public_servico from servicos s join usuarios u on s.id_prestador_servico = u.id_usuario WHERE id_servico = $this->id_servico";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getServiceSubCategories(){
        $query = "SELECT sc.id_subcategoria, sub.nome_subcategoria from servico_categorias sc join subcategorias sub on sc.id_subcategoria = sub.id_subcategoria where id_servico = $this->id_servico";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceMasterCategory(){
        $query = "SELECT sc.id_categoria, c.nome_categoria from servico_categorias sc join categorias c on sc.id_categoria = c.id_categoria where id_servico = $this->id_servico";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getQntContracts(){
        $query = "SELECT count(*) as qntContratos from contratos where id_servico = $this->id_servico";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['qntContratos'];
    }

    public function getQntComplains(){
        $query = "SELECT count(*) as qntDenuncias from denuncia_servico where id_servico = $this->id_servico";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['qntDenuncias'];
    }

    public function banThisService(){
        $query = "UPDATE servicos SET status_servico = 2 WHERE id_servico = $this->id_servico AND status_servico = 1";
        $stmt = $this->con->query($query);
        return "Serviço banido e ocultado do público";
    }

    public function unbunThisService(){
        $query = "UPDATE servicos SET status_servico = 1 WHERE id_servico = $this->id_servico AND status_servico = 2";
        $stmt = $this->con->query($query);
        return "Serviço desbanido e exibido ao público";
    }

    public function getComplainsToThisService(){
        $query = "SELECT ds.id_denuncia_servico, ds.id_denuncia_motivo, dm.denuncia_motivo, ds.id_usuario, u.nome_usuario, u.sobrenome_usuario, ds.desc_denuncia_serv, ds.data_denuncia_serv, ds.status_denuncia_serv FROM denuncia_servico ds join usuarios u on ds.id_usuario = u.id_usuario join denuncia_motivo dm on ds.id_denuncia_motivo = dm.id_denuncia_motivo WHERE ds.status_denuncia_serv in(0,1) AND ds.id_servico = $this->id_servico";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function changeComplainStatus($status, $id){
        $query = "UPDATE denuncia_servico SET status_denuncia_serv = $status WHERE id_denuncia_servico = $id";
        $stmt = $this->con->query($query);
        return "Status da denúncia alterado";
    }
}

class ContactReport {
    private $con;
    public $id_contato;

    public function __construct($id){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();

        $this->id_contato = $id;
    }

    public function getContactInfo(){
        $query = "SELECT * from fale_conosco where id_contato = $this->id_contato";
        $stmt = $this->con->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function changeContactStatus($status){
        $query = "UPDATE fale_conosco SET status_contato = $status WHERE id_contato = $this->id_contato";
        $stmt = $this->con->query($query);
        return "Status do contato alterado com sucesso";
    }

    public function sendRespForUser($userEmail, $subject, $userMsg, $ourMsg){
        #processo de envio do email com o código

        //configurando o email da empresa
        $mail = new phpMailer(true);
        $mail->SMTPDebug = false;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contato.taporaqui@gmail.com';
        $mail->Password = 'taporaqui';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = "UTF-8";
        $mail->Encoding = 'base64';

        //enviando o email com o código
        try {
            $mail->setFrom('contato.taporqui@gmail.com', 'Tá por aqui'); //remetente
            $mail->addAddress($userEmail); //destinatário
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<h3>Mensagem enviada:</h3> <p>$userMsg</p> <br> <h3>Resposta:</h3> <p>$ourMsg</p>";
            $mail->AltBody = "Essa mensagem necessita de suporte HTML";
            $mail->send();

            return "Mensagem enviada com sucesso";
        } catch (Exception $e){
            return "Erro ao enviar mensagem";
        }
    }
}

class AppControl{
    private $con;

    public function __construct(){
        //conectar com o banco
        $this->con = new DashboardConnection();
        $this->con = $this->con->connect();
    }

    public function getCategories(){
        $query = "SELECT * from categorias ORDER BY nome_categoria";
        $stmt = $this->con->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMasterCategories($categories){
        $arrCategories = explode(',', $categories);
        $queryParam = "";
        foreach ($arrCategories as $key => $c){
            if ($key !== count($arrCategories) - 1){
                $queryParam .= "('" . trim($c) . "'), ";
            } else {
                $queryParam .= "('" . trim($c) . "')";
            }
        }
        $query = "INSERT INTO categorias(nome_categoria) values $queryParam";
        $this->con->query($query);
        return "Categorias mestres inseridas com sucesso <br> query inserida: $query";
    }

    public function addSubCategories($subcategories, $masterCategory){
        $masterCategory = intval($masterCategory);
        $arrCategories = explode(',', $subcategories);
        $queryParam = "";
        foreach ($arrCategories as $key => $c){
            if ($key !== count($arrCategories) - 1){
                $queryParam .= "($masterCategory, '" . trim($c) . "'), ";
            } else {
                $queryParam .= "($masterCategory, '" . trim($c) . "')";
            }
        }
        $query = "INSERT INTO subcategorias(id_categoria, nome_subcategoria) values $queryParam";
        $this->con->query($query);
        return "Subcategorias inseridas com sucesso <br> query inserida: $query";
    }

    public function addComplainReasons($reasons, $category){
        $arrReasons = explode(',', $reasons);
        $queryParam = "";
        foreach ($arrReasons as $key => $reason){
            if ($key !== count($arrReasons) - 1){
                $queryParam .= "('" . trim($reason) . "', $category), ";
            } else {
                $queryParam .= "('" . trim($reason) . "', $category)";
            }
        }
        $query = "INSERT INTO denuncia_motivo(denuncia_motivo, categoria_motivo) values $queryParam";
        $this->con->query($query);
        return "Motivos de denúncia inseridos com sucesso inseridas com sucesso. <br> Query inserida: $query";
    }

    public function addUserExitReasons($reasons){
        $arrReasons = explode(',', $reasons);
        $queryParam = "";
        foreach ($arrReasons as $key => $reason){
            if ($key !== count($arrReasons) - 1){
                $queryParam .= "('" . trim($reason) . "'), ";
            } else {
                $queryParam .= "('" . trim($reason) . "')";
            }
        }
        $query = "INSERT INTO deletar_conta_motivos(del_motivo) values $queryParam";
        $this->con->query($query);
        return "Categorias mestres inseridas com sucesso <br> query inserida: $query";
    }
}