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

    <title>Tá por aqui - Esqueceu senha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/global/globalStyles.css">
    <link rel="stylesheet" href="esqueceuSenha.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
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

</body>
</html>