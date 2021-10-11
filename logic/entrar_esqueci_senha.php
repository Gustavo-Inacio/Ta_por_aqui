<?php
//fazer a página expirar em 10 segundos (impedir do usuário reenviar o email)

session_start();

//importando o código do PhpMailer
require '../assets/phpMailer/Exception.php';
require '../assets/phpMailer/OAuth.php';
require '../assets/phpMailer/PHPMailer.php';
require '../assets/phpMailer/POP3.php';
require '../assets/phpMailer/SMTP.php';

//usando os namespaces do PhpMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

#verificar se o email informado existe no banco de dados
$email = $_POST['emailForgotPass'];

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "SELECT email_usuario FROM usuarios WHERE email_usuario = '$email'";
$stmt = $con->query($query);
$dbEmail = $stmt->fetch(PDO::FETCH_OBJ);

$haveSSl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$currentUrl = "$haveSSl://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$absolutePath = explode('logic', $currentUrl);
$absolutePath = $absolutePath[0] . 'logic/entrar_allowChangePass.php';

if($dbEmail === false){
    //email não cadastrado
    $msg = "<p class='text-danger'>O email informado não existe nos nossos servidores. <a href='../public/Entrar/login.php'>Volte para página de login</a> e tente com outro email</p>";
} else {
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
        $mail->addAddress($email); //destinatário
        $mail->isHTML(true);
        $mail->Subject = 'Link para troca de senha';
        $mail->Body = "Para redefinir a sua senha clique no link abaixo para ser redirecionado para a página de redefinição de senha. <br> Não recarregue a página que você será redirecionado, pois ela expira rápido <br> <strong>Link:</strong> <a href='$absolutePath'>Clique aqui para ser redirecionado</a> <br> Esse link expirará em 1 hora ou depois de clicado";
        $mail->send();

        $msg = "<p class='text-success'>O email com o link para trocar senha foi enviado com sucesso. Verifique o seu email!</p>";

        #criando uma sessão temporária para troca de senha. Isso fará com que o link tenha uma válidade
        $_SESSION['emailRecSenha'] = $email;
        $_SESSION['currentTime'] = time();
        $_SESSION['expireTime'] = time() + 3600;
    } catch (Exception $e){
        $msg = "<p class='text-danger'>Houve um problema para enviar o email com o link para troca de senha. <a href='../public/Entrar/login.php'>Volte para página de login</a> e tente novamente. Se o erro persistir, entre em contato pelo <a href='../public/Contato/contato.php'>Fale conosco</a> nos informando o código de erro <br> <strong>Código do erro:</strong> " . $e->getCode();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trocar senha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/global/globalStyles.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../assets/global/globalScripts.js" defer></script>

    <style>
        body{
            font-family: 'Roboto';
            background-color: #D1F9E1;
        }

        #page{
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            margin-bottom: 20px;
        }

        #masterDiv{
            padding: 0;
            border-radius: 10px;
            align-self: center;
            margin-top: 2%;
            background-color: white;
        }

        #content{
            padding: 50px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #content h1{
            font-size: 48px;
            font-weight: 900;
            color: #3333CC;
        }

        #content i{
            font-size: 56px;
            text-align: center;
        }

        #changePassForm div{
            margin-bottom: 5px;
        }

        @media (max-width: 991.98px) {
            #content{
                padding: 30px 20px;
            }
            #content h1{
                font-size: 36px;
            }
        }

        @media (max-height: 700px){
            #myMainFooter{
                position: relative;
            }
        }
    </style>
</head>
<body>

<div id="page">
    <section id="masterDiv">
        <div id="content">
                <?=$msg?>
        </div>
    </section>
</div>

</body>
</html>