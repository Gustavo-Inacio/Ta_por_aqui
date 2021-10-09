<?php
session_start();

require "../DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//importando o código para enviar email
require '../../assets/phpMailer/Exception.php';
require '../../assets/phpMailer/OAuth.php';
require '../../assets/phpMailer/PHPMailer.php';
require '../../assets/phpMailer/POP3.php';
require '../../assets/phpMailer/SMTP.php';

//usando os namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//prestador do serviço
$query = "SELECT s.id_prestador_servico as prestador, u.email_usuario from servicos s join usuarios u on s.id_prestador_servico = u.id_usuario where id_servico = " . $_GET['idServico'];
$queryResult = $con->query($query)->fetch(PDO::FETCH_OBJ);
$prestador = $queryResult->prestador;
$email =  $queryResult->email_usuario;

//cliente do serviço
$cliente = $_SESSION['idUsuario'];

//Verificar se o contato solicitado já não existe
$query = "SELECT * FROM chat_contatos where id_servico = :id_servico AND id_prestador = :prestador AND id_cliente = :cliente";
$stmt = $con->prepare($query);
$stmt->bindValue(':id_servico', $_GET['idServico']);
$stmt->bindValue(':prestador', $prestador);
$stmt->bindValue(':cliente', $cliente);
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($contact->id_chat_contato)){
    //Já existe um contato entre esse prestador e cliente referenciando esse mesmo serviço. Redirecionando para a página chat para eles conversarem.
    echo "Contato anterior encontrado... redirecionando";

    //redirecionando para a página de chat
    header('location: ../../public/Chat/chat.php?directChat=' . $contact->id_chat_contato);
} else {
    echo "Criando novo contato... redirecionando...";

    //Criar novo contato entre prestador e cliente referenciando esse serviço
    $query = "INSERT INTO chat_contatos(id_servico, id_prestador, id_cliente, ultima_att_contato) VALUE (:id_servico, :prestador, :cliente, :ultima_att_contato)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_servico', $_GET['idServico']);
    $stmt->bindValue(':prestador', $prestador);
    $stmt->bindValue(':cliente', $cliente);
    $stmt->bindValue(':ultima_att_contato', date('Y-m-d H:i:s'));
    $stmt->execute();

    //Mandando um email para avisar o prestador que um novo cliente entrou em contato

    //url para o chat
    $haveSSl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $currentUrl = "$haveSSl://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $absolutePath = explode('logic', $currentUrl);
    $absolutePath = $absolutePath[0] . 'public/Chat/chat.php?directChat=' . $con->lastInsertId();

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

    //enviando o email
    $mail->setFrom('contato.taporqui@gmail.com', 'Tá por aqui'); //remetente
    $mail->addAddress($email); //destinatário
    $mail->isHTML(true);
    $mail->Subject = 'Novo contato criado';
    $mail->Body = "<h1>Um novo cliente entrou em contato com você</h1> <p>Um cliente se interessou por seu serviço e entrou em contato com você por meio de nosso serviço de chat.</p> <p>Inicie uma conversação com ele pelo <a href='$absolutePath'>Chat de nossa plataforma</a></p>";
    $mail->AltBody = 'Seu serviço de email precisa suportar html para visualizar essa mensagem';
    $mail->send();

    header('location: ../../public/Chat/chat.php?directChat=' . $con->lastInsertId());
}