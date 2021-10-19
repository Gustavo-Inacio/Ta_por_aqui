<?php
    session_start();
    if (isset($_SESSION['idAdm']) && isset($_SESSION['emailAdm']) && isset($_SESSION['senhaAdm'])){
        header('location:analisys.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tá por aqui - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="assets/chart.js/chart.js"></script>
    <script src="script.js" defer></script>
</head>
<body>
    <div id="page">
        <section id="loginDiv" class="row container">
            <div class="col-12">
                <div id="loginContent">
                    <?php if (isset($_GET['login']) && $_GET['login'] === "erro") {?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>Email ou senha incorreta</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php }?>
                    <h1> Entre </h1>
                    <form action="assets/loginAdm.php" method="POST" id="loginForm">
                        <label for="emailAdm" class="myLabel">Email</label> <br>
                        <input type="text" class="form-control" name="emailAdm" id="emailAdm"
                               placeholder="Email do administrador" required maxlength="40">

                        <br>

                        <label for="passAdm" class="myLabel">Senha</label> <br>
                        <input type="password" class="form-control" name="passAdm" id="passAdm"
                               placeholder="Senha do administrador" aria-describedby="viewPass" required maxlength="40">
                        <br>
                        <button type="submit" class="btn btn-success py-3 w-100"> Entrar <i
                                class="fas fa-sign-in-alt"></i></button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>