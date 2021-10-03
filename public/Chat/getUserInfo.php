<?php
session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//pegando informações do contato dessa conversa
$query = "SELECT * FROM chat_contatos where id_chat_contato = :chatId";
$stmt = $con->prepare($query);
$stmt->bindValue(':chatId', $_GET['chatId']);
$stmt->execute();
$chatInfo = $stmt->fetch(PDO::FETCH_OBJ);

//definindo exibição como prestador ou cliente
$show = "";
if($chatInfo->id_prestador != $_SESSION['idUsuario']){
    //eu sou o cliente e serão exibidas as informações do prestador
    $show = 0; //prestador
} else {
    //eu sou o prestador e serão exibidas as informações do cliente
    $show = 1; //cliente
}

//pegando informações do usuário
$userQuery = "";
if ($show == 0){
    $userQuery = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.imagem_usuario, s.id_servico, s.nome_servico FROM usuarios u join servicos s on u.id_usuario = s.id_prestador_servico WHERE u.id_usuario = :id";
} else {
    $userQuery = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.imagem_usuario FROM usuarios u WHERE u.id_usuario = :id";
}

$stmt = $con->prepare($userQuery);
$stmt->bindValue(':id', $_GET['userId']);
$stmt->execute();
$userInfo = $stmt->fetch(PDO::FETCH_OBJ);

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
    <script src="generalScripts.js"></script>
    <script>
        function downloadFileOnUserInfo(fileDirectory, filename){
            let download = document.createElement('a')
            download.href = `../../assets/chatSharedFiles/${fileDirectory}`
            download.setAttribute('download', filename)
            download.click()
            download.remove()
        }
    </script>
</head>
<body>
    <div class="userDetailedInfo">
        <img src="../../assets/images/users/<?=$userInfo->imagem_usuario?>" alt="Imagem do usuário" class="userImg userImg-lg">
        <div class="userName userName-lg"><a href="../Perfil/perfil.php?id=<?=$userInfo->id_usuario?>"><?=$userInfo->nome_usuario . " " . $userInfo->sobrenome_usuario?></a></div>
        <div class="userService"><?=$show == 0 ? $userInfo->nome_servico : $serviceName . '(meu serviço)'?></div>
    </div>

    <div class="chatMidia">
        <button type="button" class="showMidiaBtn" data-bs-toggle="collapse" data-bs-target="#chatMidiaItems" aria-expanded="false" aria-controls="collapseExample">Exibir Mídia <i class="far fa-folder-open"></i> </button>
        <div class="collapse mt-3" id="chatMidiaItems">
            <?php
            //lendo mensagens com arquivos no banco
            $query = "SELECT cm.diretorio_arquivo_chat, cm.apelido_arquivo_chat from chat_mensagens cm WHERE cm.id_chat_contato = :contato AND diretorio_arquivo_chat IS NOT NULL GROUP BY cm.id_chat_mensagem ORDER BY cm.id_chat_mensagem";
            $stmt = $con->prepare($query);
            $stmt->bindValue(':contato', $_GET['chatId']);
            $stmt->execute();
            $chatFiles = $stmt->fetchAll(PDO::FETCH_OBJ);

            if (count($chatFiles) > 0){
                foreach ($chatFiles as $file) {
                ?>
                    <div class="formatBtn chatDocItem" onclick="downloadFileOnUserInfo('<?=$file->diretorio_arquivo_chat?>', '<?=$file->apelido_arquivo_chat?>')">
                        <span class="docName"><?=$file->apelido_arquivo_chat?></span> <i class="fas fa-download"></i>
                    </div>
                <?php }
            } else {
                echo "Vocês ainda não compartilharam nenhum arquivo um com o outro";
            }?>
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
        <div class="dangerOption text-success dangerFakeLine" onclick="location.href = '../EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID=<?=$show == 0 ? $userInfo->id_servico : $serviceId?>'">Ir para o serviço <i class="fas fa-briefcase"></i></div>
        <div class="dangerOption dangerFakeLine" onclick="toggleBlockUser(0, <?=$_GET['chatId']?>, <?=$_SESSION['idUsuario']?>)">Bloquear <i class="fas fa-user-slash"></i></div>
        <div class="dangerOption">Denunciar serviço <i class="fas fa-ban"></i></div>
    </div>
</body>
