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
    //usuário vendo prestador
    $userQuery = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.imagem_usuario, u.online_usuario, s.id_servico, s.nome_servico FROM usuarios u join servicos s on u.id_usuario = s.id_prestador_servico WHERE u.id_usuario = :id";
} else {
    //prestador vendo usuário
    $userQuery = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.imagem_usuario, u.online_usuario FROM usuarios u WHERE u.id_usuario = :id";
}
$stmt = $con->prepare($userQuery);
$stmt->bindValue(':id', $_GET['userId']);
$stmt->execute();
$userInfo = $stmt->fetch(PDO::FETCH_OBJ);

//pegando nome do serviço caso a visualização seja do perfil do cliente
$query = "SELECT nome_servico from servicos where id_servico = " . $chatInfo->id_servico;
$serviceName = $con->query($query)->fetch(PDO::FETCH_OBJ)->nome_servico;
if (empty($chatInfo) || $chatInfo->status_chat_contato == 0){
    exit();
}
?>
<head>
    <script src="generalScripts.js"></script>
    <script>
        function downloadFile(fileDirectory, filename){
            let download = document.createElement('a')
            download.href = `../../assets/chatSharedFiles/${fileDirectory}`
            download.setAttribute('download', filename)
            download.click()
            download.remove()
        }

        $(document).ready(() => {
            $('#mobileBottomNavbarSection').addClass('d-none')
            $('#mobileBottomNavbarSection-spacer').addClass('d-none')
        })
    </script>
</head>
<body style="position: relative">
<div class="px-3 pb-0 pt-0 pt-md-3" style="height: calc(100vh - 157px)">
    <div class="userInfo row" id="userInfo" onclick="loadUserInfo()">
        <div class="col-2 d-flex">
            <img src="../../assets/images/users/<?=$userInfo->imagem_usuario?>" alt="profilepic" class="userImg">
        </div>

        <div class="col-8">
            <div class="userName"><?=$userInfo->nome_usuario?> <?=$userInfo->sobrenome_usuario?></div>
            <div class="userService"><?=$show == 0 ? $userInfo->nome_servico : $serviceName . '(meu serviço)'?></div>
        </div>

        <div class="col-2 d-flex align-items-center" id="statusOnlineUser">
            <?php
            if($userInfo->online_usuario == 0){
                echo '<span class="text-secondary"><i class="fas fa-circle" style="font-size: 13px"></i> Offline</span>';
            } else {
                echo '<span class="text-success"><i class="fas fa-circle" style="font-size: 13px"></i> Online</span>';
            }
            ?>
        </div>
    </div>

    <div class="chatMessages">
        <div class="chatAlert">
            <?php
            $dataCriacaoContato = new DateTime($chatInfo->criacao_chat_contato);
            if ($_SESSION['idUsuario'] == $chatInfo->id_prestador) {
                echo "Esse cliente criou um contato com você no dia {$dataCriacaoContato->format('d/m/Y')} pra saber mais de seus serviços";
            } else {
                echo "Você criou um contato com este prestador no dia {$dataCriacaoContato->format('d/m/Y')} pra saber mais de seus serviços";
            }?>
        </div>

        <?php
        //lendo mensagens do banco de dados
        $query = "SELECT cm.id_chat_mensagem, cm.id_chat_contato, cm.id_remetente_usuario, cm.id_destinatario_usuario, cm.mensagem_chat, cm.diretorio_arquivo_chat, cm.apelido_arquivo_chat, cm.hora_mensagem_chat, cm.mensagem_lida from chat_mensagens cm WHERE cm.id_chat_contato = :contato GROUP BY cm.id_chat_mensagem ORDER BY cm.id_chat_mensagem";
        $stmt = $con->prepare($query);
        $stmt->bindValue(':contato', $_GET['chatId']);
        $stmt->execute();
        $chatMessages = $stmt->fetchAll(PDO::FETCH_OBJ);

        $dataMsg = [];
        if (count($chatMessages) > 0){
            foreach ($chatMessages as $key => $message) {
                //verificando as datas das mensagens
                $horaMsg = new DateTime($message->hora_mensagem_chat);
                $formatter = new IntlDateFormatter(
                    'pt_BR',
                    IntlDateFormatter::RELATIVE_MEDIUM,
                    IntlDateFormatter::NONE,
                    'America/Sao_Paulo',
                    IntlDateFormatter::GREGORIAN
                );
                $dataMsg[$key] = $formatter->format($horaMsg);

                if($key > 0){
                    if ($dataMsg[$key] !== $dataMsg[intval($key)-1]){
                        echo "<div class='chatDate'>$dataMsg[$key]</div>";
                    }
                } else {
                    echo "<div class='chatDate'>$dataMsg[$key]</div>";
                }
            ?>
                <div class="message <?=$_SESSION['idUsuario'] == $message->id_remetente_usuario ? 'myMessage' : 'itsMessage'?>" id="<?=$message->id_chat_mensagem?>">
                    <?php if ($message->mensagem_chat === "arquivo" && $message->diretorio_arquivo_chat != null){
                            $tmparr = explode('.', $message->diretorio_arquivo_chat);
                            $extension = $tmparr[count($tmparr) - 1];

                            if ($extension === 'png' || $extension === 'jpg' || $extension === 'jpeg') {?>
                                <div class="d-flex justify-content-center">
                                    <img src="../../assets/chatSharedFiles/<?=$message->diretorio_arquivo_chat?>" alt="imagem compartilhada" class="chatImg">
                                </div>
                            <?php } else if ($extension === 'mp4'){ ?>
                                <video class="chatVideo" controls>
                                    <source src="../../assets/chatSharedFiles/<?=$message->diretorio_arquivo_chat?>" type="video/mp4">

                                    <!-- mensagem caso o browser não suprote o player -->
                                    <span class="text-danger">Seu browser não suporta o player de vídeo. Em vez disso baixe o vídeo:</span> <br>
                                    <div class="messageArq" onclick="downloadFile('<?=$message->diretorio_arquivo_chat?>', '<?=$message->apelido_arquivo_chat?>')">
                                        <?=$message->apelido_arquivo_chat?> <i class="fas fa-download" style="margin-left: auto"></i>
                                    </div>
                                </video>
                            <?php } else if ($extension === 'mp3') { ?>
                                <audio class="chatAudio" controls>
                                    <source src="../../assets/chatSharedFiles/<?=$message->diretorio_arquivo_chat?>" type="audio/mpeg">

                                    <!-- mensagem caso o browser não suprote o player -->
                                    <span class="text-danger">Seu browser não suporta o player de vídeo. Em vez disso baixe o vídeo:</span> <br>
                                    <div class="messageArq" onclick="downloadFile('<?=$message->diretorio_arquivo_chat?>', '<?=$message->apelido_arquivo_chat?>')">
                                        <?=$message->apelido_arquivo_chat?> <i class="fas fa-download" style="margin-left: auto"></i>
                                    </div>
                                </audio>
                            <?php }  else {?>
                                <div class="messageArq" onclick="downloadFile('<?=$message->diretorio_arquivo_chat?>', '<?=$message->apelido_arquivo_chat?>')">
                                    <?=$message->apelido_arquivo_chat?> <i class="fas fa-download" style="margin-left: auto"></i>
                                </div>
                            <?php }?>
                    <?php } else {?>
                        <div class="messageText">
                            <?=nl2br($message->mensagem_chat)?>
                        </div>
                    <?php }
                    if ($message->id_remetente_usuario == $_SESSION['idUsuario']) {?>
                    <div style="text-align: end">
                        <div class="messageTime me-2"><?=$horaMsg->format('H:i')?></div>
                        <div class="msgRead"><?=$message->mensagem_lida ? '<i class="fas fa-check-double text-primary"></i>' : '<i class="fas fa-check text-secondary"></i>'?></div>
                    </div>
                    <?php } else {?>
                        <div style="text-align: end">
                            <div class="messageTime me-3"><?=$horaMsg->format('H:i')?></div>
                        </div>
                    <?php }?>
                </div>
            <?php }
        } else {
            echo "<div class='message d-none'>Nenhuma mensagem no chat ainda</div>";
        }?>
    </div>
</div>
</body>
