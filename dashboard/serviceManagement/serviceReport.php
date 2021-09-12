<?php
require "../assets/getData.php";
$servicesListing = new ServicesListing();
$services = [];
if (isset($_POST['serviceStatus'])){
    $services = $servicesListing->selectFilteredServices($_POST['serviceStatus'], $_POST['serviceComplainFilter']);
} else if (isset($_POST['searchInput'])){
    $services = $servicesListing->selectSearchedServices($_POST['searchInput'], $_POST['searchParam']);
} else {
    $services = $servicesListing->selectAllServices();
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
    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../assets/bootstrap/popper.min.js" defer></script>
    <script src="../../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

    <script src="../script.js" defer></script>

    <script>
        //remover transição do collapse quando a página carrega e devolve-la quando clicado
        $(document).ready(() => {
            $('#gerenciamentoServicos').collapse('show')
            $('#gerenciamentoServicos').removeClass('collapsing')
            $('#gerenciamentoServicos').on("click", () => {
                $('#gerenciamentoServicos').addClass('collapsing')
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

            <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="../userManagement/userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li><a href="../userManagement/commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="../userManagement/contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed active">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li class="active"><a href="serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#appControl" class="collapsed">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="../appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
                <li><a href="../appControl/addComplainReason.php"><i class="fa fa-angle-right"></i> Adicionar denúncias motivos</a></li>
                <li><a href="../appControl/addExitReason.php"><i class="fa fa-angle-right"></i> Adicionar saída motivos</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Relatório de serviços</h1>

    <form action="serviceReport.php" method="post">
        <div class="float-left">
            <label for="serviceStatus">Filtrar por atividade: </label> <br>
            <select name="serviceStatus" id="serviceStatus">
                <option value="">Todos os serviços</option>
                <option value="1" <?php if (isset($_POST['serviceStatus']) and $_POST['serviceStatus'] == 1) {echo 'selected';}?>>Serviços ativos</option>
                <option value="2" <?php if (isset($_POST['serviceStatus']) and $_POST['serviceStatus'] == 2) {echo 'selected';}?>>Serviços banidos</option>
                <option value="0" <?php if (isset($_POST['serviceStatus']) and $_POST['serviceStatus'] == 0) {echo 'selected';}?>>Serviços suspensos</option>
                <option value="3" <?php if (isset($_POST['serviceStatus']) and $_POST['serviceStatus'] == 3) {echo 'selected';}?>>Serviços ocultados pelo user</option>
            </select>
        </div>

        <div class="float-left">
            <label for="serviceComplainFilter">Filtrar denúncias: </label> <br>
            <select name="serviceComplainFilter" id="serviceComplainFilter">
                <option value="">Todos os serviços</option>
                <option value="true" <?php if (isset($_POST['serviceComplainFilter']) and $_POST['serviceComplainFilter'] == true) {echo 'selected';}?>>Serviços denunciados</option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-left">Aplicar filtros</button>
    </form>

    <div class="clearfix my-3"></div>

    <form action="serviceReport.php" method="post">
        <div class="float-left">
            <label for="searchInput">Pesquisar serviço:</label> <br>
            <input type="text" name="searchInput" <?php if (isset($_POST['searchInput'])) {echo "value = '" . $_POST['searchInput'] . "'";}?>>
            <select name="searchParam" id="searchParam">
                <option value="id_servico" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'id_servico') {echo 'selected';}?>>id do serviço</option>
                <option value="id_prestador_servico" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'id_prestador_servico') {echo 'selected';}?>>id do prestador</option>
                <option value="nome_usuario" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'nome_prestador') {echo 'selected';}?>>nome do prestador</option>
                <option value="nome_servico" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'nome_servico') {echo 'selected';}?>>nome do serviço</option>
                <option value="crit_orcamento_servico" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'crit_orcamento_servico') {echo 'selected';}?>>critério de preço</option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-left">Pesquisar</button>
    </form>

    <div class="clearfix my-3"></div>

    <div class="row my-2">
        <div class="col-md-12 col-lg-10">
            <?php foreach ($services as $service) {?>
                <div class="listDiv row my-3" onclick="redirecionaPagina('service.php', <?=$service['id_servico']?>)">
                    <div class="col-sm-1 mr-2 mb-3 mb-sm-0">
                        <img src="../../assets/images/dumb-brand.png" alt="imagem do serviço" class="userPicture">
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span><?=$service['nome_servico']?> (id <?=$service['id_servico']?>)</span> <br>
                        <span class="text-secondary"><?=$service['nome_usuario']?> (id <?=$service['id_prestador_servico']?>)</span>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <span>Serviço <?php echo $service['tipo_servico'] === 0 ? " presencial" : " remoto"?></span> <br>
                        <span class="text-secondary">nota média: <?=$service['nota_media_servico']?>/5.0</span>
                    </div>
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <?php
                            if ($service['status_servico'] == 0){
                                echo '<span class="text-secondary">Servico suspenso</span>';
                            } else if ($service['status_servico'] == 1){
                                echo '<span class="text-success">Servico ativo</span>';
                            } else if ($service['status_servico'] == 2) {
                                echo '<span class="text-danger">Servico banido</span>';
                            } else {
                                echo '<span class="text-secondary">Servico ocultado pelo usuário</span>';
                            }
                            ?> <br>
                            <span>Denúncias: <?=$servicesListing->getQntComplains($service['id_servico'])?></span>
                        </div>
                    </div>
            <?php }?>
        </div>
    </div>
</div>

</body>

</html>