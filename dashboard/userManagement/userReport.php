<?php
require "../assets/getData.php";

session_start();
if (empty($_SESSION['idAdm']) || empty($_SESSION['emailAdm']) || empty($_SESSION['senhaAdm'])) {
    header('location:../index.php');
    exit();
}

$usersListing = new UsersListing();

//seleção de resultados
$users = [];
if (isset($_GET['userStatus']) || isset($_GET['userClassification'])) {
    $users = $usersListing->selectFilteredUsers($_GET['userStatus'], $_GET['userClassification']);
} else if (isset($_GET['searchInput'])) {
    $users = $usersListing->selectSearchedUsers($_GET['searchInput'], $_GET['searchParam']);
} else {
    $users = $usersListing->selectAllUsers();
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

    <script>
        //remover transição do collapse quando a página carrega e devolve-la quando clicado
        $(document).ready(() => {
            let bsgGerenciamentoUsuarios = new bootstrap.Collapse(document.getElementById('gerenciamentoUsuarios'))
            bsgGerenciamentoUsuarios.show()
            $('#gerenciamentoUsuarios').removeClass('collapsing')
            $('#gerenciamentoUsuarios').on("click", () => {
                $('#gerenciamentoUsuarios').addClass('collapsing')
            })
        })

        function redirecionaPagina(pag, param) {
            location.href = `${pag}?id=${param}`
        }
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

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoUsuarios" class="collapsed active">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span
                            class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li class="active"><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a>
                </li>
                <li><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span
                            class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de
                        serviços</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#appControl" class="collapsed">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i
                                class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="../appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a>
                </li>
                <li><a href="../appControl/addComplainReason.php"><i class="fa fa-angle-right"></i> Adicionar denúncias
                        motivos</a></li>
                <li><a href="../appControl/addExitReason.php"><i class="fa fa-angle-right"></i> Adicionar saída motivos</a>
                </li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Relatório de usuários</h1>

    <form action="userReport.php" method="get">
        <div class="float-start">
            <label class="me-2" for="userStatus">Filtrar por atividade: </label> <br>
            <select class="me-2" name="userStatus" id="userStatus">
                <option value="">Todos os usuários</option>
                <option value="1" <?php if (isset($_GET['userStatus']) and $_GET['userStatus'] == 1) {
                    echo 'selected';
                } ?>>Usuários ativos
                </option>
                <option value="2" <?php if (isset($_GET['userStatus']) and $_GET['userStatus'] == 2) {
                    echo 'selected';
                } ?>>Usuários banidos
                </option>
                <option value="0" <?php if (isset($_GET['userStatus']) and $_GET['userStatus'] == 0) {
                    echo 'selected';
                } ?>>Usuários suspensos
                </option>
            </select>
        </div>

        <div class="float-start">
            <label class="me-2" for="userFilter">Filtrar por classificação: </label> <br>
            <select class="me-2" name="userClassification" id="userClassification">
                <option value="">Todos os usuários</option>
                <option value="1" <?php if (isset($_GET['userClassification']) and $_GET['userClassification'] == 1) {
                    echo 'selected';
                } ?>>Prestadores
                </option>
                <option value="2" <?php if (isset($_GET['userClassification']) and $_GET['userClassification'] == 2) {
                    echo 'selected';
                } ?>>Pequeno negócio
                </option>
                <option value="0" <?php if (isset($_GET['userClassification']) and $_GET['userClassification'] == 0) {
                    echo 'selected';
                } ?>>Clientes
                </option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-start">Aplicar filtros</button>
    </form>

    <div class="clearfix my-3"></div>

    <form action="userReport.php" method="get">
        <div class="float-start">
            <label for="searchInput">Pesquisar usuário:</label> <br>
            <input class="me-2" type="text" name="searchInput" <?php if (isset($_GET['searchInput'])) {
                echo "value = '" . $_GET['searchInput'] . "'";
            } ?>>
            <select class="me-2" name="searchParam" id="searchParam">
                <option value="id_usuario">id</option>
                <option value="nome_usuario" <?php if (isset($_GET['searchParam']) and $_GET['searchParam'] == 'nome_usuario') {
                    echo 'selected';
                } ?>>nome
                </option>
                <option value="email_usuario" <?php if (isset($_GET['searchParam']) and $_GET['searchParam'] == 'email_usuario') {
                    echo 'selected';
                } ?>>email
                </option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-start">Pesquisar</button>
    </form>

    <div class="clearfix my-3"></div>

    <div class="row my-2">
        <div class="col-md-12 col-lg-10">
            <?php foreach ($users as $user) { ?>
                <div class="listDiv row my-3" onclick="redirecionaPagina('user.php', <?= $user['id_usuario'] ?>)">
                    <div class="col-sm-1 mr-2 mb-3 mb-sm-0">
                        <img src="../../assets/images/users/<?= $user['imagem_usuario'] ?>" alt="imagem do usuário"
                             class="userPicture">
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span><?= $user['nome_usuario'] ?> (<?= $user['id_usuario'] ?>)</span> <br>
                        <span class="text-secondary"><?= $user['classif_usuario'] == 0 ? "cliente" : "prestador" ?></span>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <span><?= $user['email_usuario'] ?></span> <br>
                        <span class="text-secondary">nota média: <?= $user['classif_usuario'] != 0 ? $user['nota_media_usuario'] : "-" ?>/5</span>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <?php
                        if ($user['status_usuario'] == 0) {
                            echo '<span class="text-secondary">Usuário suspenso</span> <br>';
                        } else if ($user['status_usuario'] == 1) {
                            echo '<span class="text-success">Usuário ativo</span> <br>';
                        } else {
                            echo '<span class="text-danger">Usuário banido</span> <br>';
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

</body>

</html>