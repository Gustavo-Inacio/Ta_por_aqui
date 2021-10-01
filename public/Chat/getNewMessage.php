<?php
$id_chat = $_POST['chatId'];
$id_ultima_msg = $_POST['lastMsgId'];
$id_remetente = $_POST['idRemetente'];

session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//lendo mensagens do banco de dados
$query = "SELECT cm.id_chat_mensagem, cm.id_chat_contato, cm.id_remetente_usuario, cm.id_destinatario_usuario, cm.mensagem_chat, cm.arquivo_chat, cm.hora_mensagem_chat from chat_mensagens cm WHERE cm.id_chat_contato = :contato GROUP BY cm.id_chat_mensagem ORDER BY cm.id_chat_mensagem DESC LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindValue(':contato', $id_chat);
$stmt->execute();
$lastMessage = $stmt->fetch(PDO::FETCH_OBJ);

if ($id_ultima_msg == $lastMessage->id_chat_mensagem){
    echo "sameMsg";
} else { ?>
    <div class="message <?=$_SESSION['idUsuario'] == $id_remetente ? 'myMessage' : 'itsMessage'?>">
        <div class="messageText">
            <?=$lastMessage->mensagem_chat?>
        </div>
        <?php
        $horaMsg = new DateTime($lastMessage->hora_mensagem_chat)
        ?>
        <div class="messageTime"><?=$horaMsg->format('H:i')?></div>
    </div>
<?php }?>