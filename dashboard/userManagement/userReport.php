<?php
    require "../assets/getData.php";
    $usersListing = new UsersListing();
    $users = [];
    if (isset($_POST['userStatus']) || isset($_POST['userClassification'])){
        $users = $usersListing->selectFilteredUsers($_POST['userStatus'], $_POST['userClassification']);
    } else if (isset($_POST['searchInput'])){
        $users = $usersListing->selectSearchedUsers($_POST['searchInput'], $_POST['searchParam']);
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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../script.js" defer></script>

    <script>
        //remover transição do collapse quando a página carrega e devolve-la quando clicado
        $(document).ready(() => {
            $('#gerenciamentoUsuarios').collapse('show')
            $('#gerenciamentoUsuarios').removeClass('collapsing')
            $('#gerenciamentoUsuarios').on("click", () => {
                $('#gerenciamentoUsuarios').addClass('collapsing')
            })
        })

        function redirecionaPagina(pag, param){
            location.href = `${pag}?id=${param}`
        }
    </script>
</head>

<body>

<!-- menu -->
<div class="nav-side-menu">
    <div class="brand py-2"><img src="../../assets/images/dumb-brand.png" alt="logo"></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <a href="../index.php"><i class="fas fa-chart-bar sidebar-icon"></i> Estatísticas do site</a>
            </li>

            <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed active">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span
                            class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li class="active"><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a>
                </li>
                <li><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span
                            class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de
                        serviços</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#appControl" class="collapsed">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i
                                class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="../appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a>
                </li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Relatório de usuários</h1>

    <form action="userReport.php" method="post">
        <div class="float-left">
            <label for="userStatus">Filtrar por atividade: </label> <br>
            <select name="userStatus" id="userStatus">
                <option value="">Todos os usuários</option>
                <option value="1" <?php if (isset($_POST['userStatus']) and $_POST['userStatus'] == 1) {echo 'selected';}?>>Usuários ativos</option>
                <option value="2" <?php if (isset($_POST['userStatus']) and $_POST['userStatus'] == 2) {echo 'selected';}?>>Usuários banidos</option>
                <option value="0" <?php if (isset($_POST['userStatus']) and $_POST['userStatus'] == 0) {echo 'selected';}?>>Usuários suspensos</option>
            </select>
        </div>

        <div class="float-left">
            <label for="userFilter">Filtrar por classificação: </label> <br>
            <select name="userClassification" id="userClassification">
                <option value="">Todos os usuários</option>
                <option value="1" <?php if (isset($_POST['userClassification']) and $_POST['userClassification'] == 1) {echo 'selected';}?>>Prestadores</option>
                <option value="2" <?php if (isset($_POST['userClassification']) and $_POST['userClassification'] == 2) {echo 'selected';}?>>Pequeno negócio</option>
                <option value="0" <?php if (isset($_POST['userClassification']) and $_POST['userClassification'] == 0) {echo 'selected';}?>>Clientes</option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-left">Aplicar filtros</button>
    </form>

    <div class="clearfix my-3"></div>

    <form action="userReport.php" method="post">
        <div class="float-left">
            <label for="searchInput">Pesquisar usuário:</label> <br>
            <input type="text" name="searchInput" <?php if (isset($_POST['searchInput'])) {echo "value = '" . $_POST['searchInput'] . "'";}?>>
            <select name="searchParam" id="searchParam">
                <option value="id_usuario">id</option>
                <option value="nome_usuario" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'nome_usuario') {echo 'selected';}?>>nome</option>
                <option value="email_usuario" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'email_usuario') {echo 'selected';}?>>email</option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-left">Pesquisar</button>
    </form>

    <div class="clearfix my-3"></div>

    <div class="row my-2">
        <div class="col-md-12 col-lg-10">
            <?php foreach ($users as $user) {?>
                <div class="listDiv row my-3" onclick="redirecionaPagina('user.php', <?=$user['id_usuario']?>)">
                    <div class="col-sm-1 mr-2 mb-3 mb-sm-0">
                        <img src="../../assets/images/users/<?=$user['imagem_usuario']?>" alt="imagem do usuário" class="userPicture">
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span><?=$user['nome_usuario']?> (<?=$user['id_usuario']?>)</span> <br>
                        <span class="text-secondary"><?= $user['classif_usuario'] == 0 ? "cliente" : "prestador" ?></span>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <span><?=$user['email_usuario']?></span> <br>
                        <span class="text-secondary">nota média: <?= $user['classif_usuario'] != 0 ? $user['nota_media_usuario'] : "-" ?>/5</span>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <?php
                            if ($user['status_usuario'] == 0){
                                echo '<span class="text-secondary">Usuário suspenso</span> <br>';
                            } else if ($user['status_usuario'] == 1){
                                echo '<span class="text-success">Usuário ativo</span> <br>';
                            } else {
                                echo '<span class="text-danger">Usuário banido</span> <br>';
                            }
                        ?>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

</body>

</html>