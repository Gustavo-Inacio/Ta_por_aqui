<?php
require "../assets/getData.php";

session_start();
if (empty($_SESSION['idAdm']) || empty($_SESSION['emailAdm']) || empty($_SESSION['senhaAdm'])){
    header('location:../index.php');
    exit();
}

$createComplainReasons = new AppControl();
$operationMsg = "";

if (isset($_POST['reasonCategory']) && isset($_POST['complainReasons'])){
    $operationMsg = $createComplainReasons->addComplainReasons($_POST['complainReasons'], $_POST['reasonCategory']);
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
    <link rel="stylesheet" href="../style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2a19bde8ca.js" crossorigin="anonymous" defer></script>
    <script src="../assets/chart.js/chart.js"></script>
    <script src="../script.js" defer></script>

    <script src="../script.js" defer></script>

    <script>
        $(document).ready(() => {
            let bsAppControl = new bootstrap.Collapse(document.getElementById('appControl'))
            bsAppControl.show()
            $('#appControl').removeClass('collapsing')
            $('#appControl').on("click", () => {
                $('#appControl').addClass('collapsing')
            })
        })
    </script>
</head>

<body>

<!-- menu -->
<div class="nav-side-menu">
    <div class="brand py-2"><img src="../../assets/images/dumb-brand.png" alt="logo"></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-bs-toggle="collapse" data-bs-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <a href="../analisys.php"><i class="fas fa-chart-bar sidebar-icon"></i> Estatísticas do site</a>
            </li>

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoUsuarios" class="collapsed">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="../userManagement/userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li><a href="../userManagement/commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="../userManagement/contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#appControl" class="collapsed active">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
                <li class="active"><a href="addComplainReason.php"><i class="fa fa-angle-right"></i> Adicionar denúncias</a></li>
                <li><a href="addExitReason.php"><i class="fa fa-angle-right"></i> Adicionar saída motivos</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Adicionar motivos de denúncia</h1>

    <?php if ($operationMsg !== "") { ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <span><?=$operationMsg?></span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    <?php }?>

    <div id="addComplainReason" class="my-4">
        <form action="addComplainReason.php" method="post">
            <label for="reasonCategory">Esse motivo de denúncia será referente à </label>
            <select name="reasonCategory" id="reasonCategory" required>
                <option value="1">Serviços</option>
                <option value="2">Comentários</option>
            </select>
            <br> <br>

            <label for="complainReasons">Digite os motivos que serão adicionados</label> <br>
            <textarea name="complainReasons" id="complainReasons" cols="50" rows="4" required placeholder="escreva o(s) motivo(s) e caso haja mais de uma separe por vírgula. Exemplo: Racismo, Spam, Ameaça de perigo, Xenofobia"></textarea> <br>
            <button type="submit">Adicionar</button>
        </form>

    </div>
</div>
</body>
</html>