<?php
session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//pegando informações do usuário
$userQuery = "";
if ($_GET['show'] == 0){
    $userQuery = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.imagem_usuario, s.id_servico, s.nome_servico FROM usuarios u join servicos s on u.id_usuario = s.id_prestador_servico WHERE u.id_usuario = :id";
} else {
    $userQuery = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.imagem_usuario FROM usuarios u WHERE u.id_usuario = :id";
}
$stmt = $con->prepare($userQuery);
$stmt->bindValue(':id', $_GET['userId']);
$stmt->execute();
$userInfo = $stmt->fetch(PDO::FETCH_OBJ);

//pegando informações do contato dessa conversa
$query = "SELECT * FROM chat_contatos where id_chat_contato = :chatId";
$stmt = $con->prepare($query);
$stmt->bindValue(':chatId', $_GET['chatId']);
$stmt->execute();
$chatInfo = $stmt->fetch(PDO::FETCH_OBJ);

//pegando nome do serviço caso a visualização seja do perfil do cliente
$query = "SELECT id_servico, nome_servico from servicos where id_servico = " . $chatInfo->id_servico;
$result = $con->query($query)->fetch(PDO::FETCH_OBJ);
$serviceName = $result->nome_servico;
$serviceId = $result->id_servico;

//verificando se essa conversa está favoritada
$query = "SELECT * FROM chat_contatos_favoritos where id_usuario = " . $_SESSION['idUsuario'] . " AND id_chat_contato = " . $_GET['chatId'];
$favoriteChat = $con->query($query)->fetch(PDO::FETCH_ASSOC);
$isFavorite = false;
if (isset($favoriteChat['id_chat_favorito'])){
    $isFavorite = true;
}

if (empty($chatInfo)){
    exit();
}
?>
<head>
    <script src="chat.js"></script>
</head>
<body>
    <div class="userDetailedInfo">
        <img src="../../assets/images/users/<?=$userInfo->imagem_usuario?>" alt="Imagem do usuário" class="userImg userImg-lg">
        <div class="userName userName-lg"><a href="../Perfil/perfil.php?id=<?=$userInfo->id_usuario?>"><?=$userInfo->nome_usuario . " " . $userInfo->sobrenome_usuario?></a></div>
        <div class="userService"><?=$_GET['show'] == 0 ? $userInfo->nome_servico : $serviceName . '(meu serviço)'?></div>
    </div>

    <div class="chatMidia">
        <button type="button" class="showMidiaBtn" data-bs-toggle="collapse" data-bs-target="#chatMidiaItems" aria-expanded="false" aria-controls="collapseExample">Exibir Mídia <i class="far fa-folder-open"></i> </button>
        <div class="collapse mt-3" id="chatMidiaItems">

            <button type="button" class="btnToggle btnPhotos d-flex justify-content-around align-items-center" data-bs-toggle="collapse" data-bs-target="#chatMidiaList" aria-expanded="false" aria-controls="chatMidiaList">
                <i class="far fa-file-image"></i> Formatos de mídia (5) <i class="fas fa-sort-down"></i>
            </button>
            <div class="collapse" id="chatMidiaList">
                <img src="../../assets/images/landing-img.png" alt="foto" class="chatMidiaItem">
            </div>

            <button type="button" class="btnToggle btnDocs d-flex justify-content-around align-items-center" data-bs-toggle="collapse" data-bs-target="#chatDocList" aria-expanded="false" aria-controls="chatDocList">
                <i class="far fa-file-pdf"></i> Documentos (17) <i class="fas fa-sort-down"></i>
            </button>
            <div class="collapse" id="chatDocList">
                <div class="formatBtn chatDocItem">
                    <i class="far fa-file-pdf"></i> <span class="docName">nome do arquivo</span> <i class="fas fa-download"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="chatOptions">
        <div class="addFavorite">
            Adicionar aos favoritos
            <label class="switch">
                <input type="checkbox" onclick="favoriteUser(this, <?=$_SESSION['idUsuario']?>, <?=$_GET['chatId']?>)" <?=$isFavorite ? 'checked' : ''?>>
                <span class="slider round"></span>
            </label>
        </div>
        <hr>
        <div class="dangerOption text-success dangerFakeLine" onclick="location.href = '../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$_GET['show'] == 0 ? $userInfo->id_servico : $serviceId?>'">Ir para o serviço <i class="fas fa-briefcase"></i></div>
        <div class="dangerOption dangerFakeLine" onclick="toggleBlockUser(0, <?=$_GET['chatId']?>, <?=$_SESSION['idUsuario']?>)">Bloquear <i class="fas fa-user-slash"></i></div>
        <div class="dangerOption">Denunciar serviço <i class="fas fa-ban"></i></div>
    </div>
</body>
