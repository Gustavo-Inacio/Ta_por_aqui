<?php
session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//pegando informações do usuário
$userQuery = "";
if ($_GET['show'] == 0){
    //usuário vendo prestador
    $userQuery = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.imagem_usuario, s.id_servico, s.nome_servico FROM usuarios u join servicos s on u.id_usuario = s.id_prestador_servico WHERE u.id_usuario = :id";
} else {
    //prestador vendo usuário
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
$query = "SELECT nome_servico from servicos where id_servico = " . $chatInfo->id_servico;
$serviceName = $con->query($query)->fetch(PDO::FETCH_OBJ)->nome_servico;
if (empty($chatInfo) || $chatInfo->status_chat_contato == 0){
    exit();
}
?>
<head>
    <script src="chat.js"></script>
</head>
<body style="position: relative">
<div class="px-3 pb-0 pt-0 pt-md-3" style="height: calc(100vh - 157px)">
    <div class="userInfo row" id="userInfo" onclick="loadUserInfo()">
        <div class="col-2 d-flex">
            <img src="../../assets/images/users/<?=$userInfo->imagem_usuario?>" alt="profilepic" class="userImg">
        </div>

        <div class="col-8">
            <div class="userName"><?=$userInfo->nome_usuario?> <?=$userInfo->sobrenome_usuario?></div>
            <div class="userService"><?=$_GET['show'] == 0 ? $userInfo->nome_servico : $serviceName . '(meu serviço)'?></div>
        </div>

        <div class="col-2 d-flex align-items-center">
            <span class="text-secondary"><i class="fas fa-circle" style="font-size: 13px"></i> Offline</span>
        </div>
    </div>

    <div class="chatMessages">
        <?php
        //lendo mensagens do banco de dados
        $query = "SELECT cm.id_chat_mensagem, cm.id_chat_contato, cm.id_remetente_usuario, cm.id_destinatario_usuario, cm.mensagem_chat, cm.arquivo_chat, cm.hora_mensagem_chat from chat_mensagens cm WHERE cm.id_chat_contato = :contato GROUP BY cm.id_chat_mensagem ORDER BY cm.id_chat_mensagem";
        $stmt = $con->prepare($query);
        $stmt->bindValue(':contato', $_GET['chatId']);
        $stmt->execute();
        $chatMessages = $stmt->fetchAll(PDO::FETCH_OBJ);
        ?>
        <!-- <div class="chatDate">Ontem</div> -->

        <?php foreach ($chatMessages as $message) {?>
            <div class="message <?=$_SESSION['idUsuario'] == $message->id_remetente_usuario ? 'myMessage' : 'itsMessage'?>">
                <div class="messageText">
                    <?=$message->mensagem_chat?>
                </div>
                <?php
                $horaMsg = new DateTime($message->hora_mensagem_chat)
                ?>
                <div class="messageTime"><?=$horaMsg->format('H:i')?></div>
            </div>
        <?php }?>

        <!--<div class="message itsMessage">
            <div class="messageText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At eveniet ipsam
                laborum nam nobis perferendis rerum ullam, velit. Aut dicta ducimus incidunt itaque nihil,
                officia placeat praesentium quisquam sint voluptatum.
            </div>
            <div class="messageTime">16:00</div>
        </div>-->

    </div>
</div>
</body>
