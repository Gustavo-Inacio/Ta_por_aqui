<?php
session_start();

#verificar se o email já está cadastrado no banco de dados
$email = $_GET['email'];

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();
$query = "SELECT email_usuario FROM usuarios WHERE email_usuario = '$email'";
$stmt = $con->query($query);
$DbEmail = $stmt->fetch(PDO::FETCH_OBJ);

if( !$DbEmail === false ){
    //email já cadastrado
    $return = ['status' => 'email_cadastrado'];
    echo json_encode($return);
    exit;
} 

//email ainda não cadastrado
$code = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
$_SESSION['confirmCode'] = $code;

#processo de envio do email com o código
//importando o código
require '../assets/phpMailer/Exception.php';
require '../assets/phpMailer/OAuth.php';
require '../assets/phpMailer/PHPMailer.php';
require '../assets/phpMailer/POP3.php';
require '../assets/phpMailer/SMTP.php';

//usando os namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    $mail->addAddress($email); //destinatário
    $mail->isHTML(true);
    $mail->Subject = 'código de verificação do email';
    $mail->Body = "<h1>Código de verificação do email</h1> <br> <p>Cole o seguinte código na janela da página de cadastro</p> <br> <strong>" . $_SESSION['confirmCode'] . "</strong>";
    $mail->AltBody = 'Cole o seguinte código na janela da página de cadastro: ' . $_SESSION['confirmCode'];
    $mail->send();

    $return = ['status' => 'enviado', 'code' => $_SESSION['confirmCode']];
    echo json_encode($return);
} catch (Exception $e){
    $return = ['status' => 'erro', 'erro' => print_r($e)];
    echo json_encode($return);
}