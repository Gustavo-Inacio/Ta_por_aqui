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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../assets/bootstrap/popper.min.js" defer></script>
    <script src="../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="assets/chart.js/chart.js"></script>

    <script src="script.js"></script>
</head>
<body>
    <div id="page">
        <section id="loginDiv" class="row container">
            <div class="col-12">
                <div id="loginContent">
                    <?php if (isset($_GET['login']) && $_GET['login'] === "erro") {?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>Email ou senha incorreta</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
                        <button type="submit" class="btn btn-block btn-success py-3"> Entrar <i
                                class="fas fa-sign-in-alt"></i></button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>