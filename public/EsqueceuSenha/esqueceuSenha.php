<?php
//Essa página só será carregada se o usuário tiver passado pela páagina entrar_allowChangePass.php
if (!isset($_COOKIE['allowChangePass'])){
    die("Essa página expirou <a href='../Entrar/login.php'> volte para página de login</a>");
}

session_start();

//verificar se o link expirou
$_SESSION['currentTime'] = time();
if (!isset($_SESSION['expireTime']) || $_SESSION['currentTime'] >= $_SESSION['expireTime']){
    session_destroy();
    exit("O link expirou");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>

    <title>Trocar senha</title>

    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="esqueceuSenha.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../../assets/global/globalScripts.js" defer></script>
    <script src="esqueceuSenha.js" defer></script>
</head>
<body>

<div id="page">
    <section id="masterDiv">
        <div>
            <div id="content">
                <div id="alertError" class="alert alert-danger d-none" role="alert" style="margin-top: -30px">
                    <span id="msgErro"></span>
                </div>

                <div id="changePass" class="border p-4">
                    <p class="text-info mb-4">
                        Crie uma nova senha com pelo menos 8 caracteres, contendo letras e números
                    </p>

                    <form id="changePassForm" action="../../logic/trocarsenha_deslogado.php" method="POST">
                        <input type="password" class="form-control mb-2" id="newPass" name="newPass" placeholder="Nova senha" required>
                        <input type="password" class="form-control mb-2" id="confirmNewPass" name="confirmNewPass" placeholder="Confirme a nova senha" required>

                        <button type="button" class="mybtn mybtn-conversion" onclick="validateNewPass()">Alterar senha</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<footer id="myMainFooter">
    <div id="myMainFooterContainer" class="container-fluid">
        <div class="my-main-footer-logo">
            <img src="../../assets/images/dumb-footer.png" alt="Tá por Aqui" class="my-footer-img">
        </div>
        <div class="my-main-footer-institutional">
            <p>INSTITUCIONAL</p>
            <a href="sobreNos.php">Quem Somos</a> <br>
            <a href="#">Faça uma doação</a> <br>
            <a href="#">Trabalhe conosco</a> <br>
        </div>
        <div class="my-main-footer-socialMedia">
            <p>Redes Sociais</p>
            <div class="my-footer-social-medias-div">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    </div>
</footer>
</body>
</html>