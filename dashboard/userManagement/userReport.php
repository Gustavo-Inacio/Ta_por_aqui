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
            $('#gerenciamentoUsuarios').collapse('show')
            $('#gerenciamentoUsuarios').removeClass('collapsing')
            $('#gerenciamentoUsuarios').on("click", () => {
                $('#gerenciamentoUsuarios').addClass('collapsing')
            })
        })
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

            <li>
                <a href="../analisys/charts.php"><i class="fas fa-chart-pie sidebar-icon"></i> Gráficos</a>
            </li>
            <li>
                <a href="../analisys/webalizer.php"><i class="fas fa-chart-line sidebar-icon"></i> Webalizer</a>
            </li>

            <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed active">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li class="active"><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="contact.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
                <li><a href="../serviceManagement/serviceComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de serviços</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#appControl" class="collapsed">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li><a href="../appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Relatório de usuários</h1>
    <br>
    <ul>
        <li>Colocar filtro de usuário banidos, suspensos ou ativos</li>
        <li>Listar todos os usuários do site em ordem alfabética</li>
        <li>Cada usuário listado seráa um link para uma página específica do usuário</li>
        <li>Essa página gerará relatórios de: Informações pessoais, quantidade de serviços denunciados</li>
        <li>Botão para banir ou desbanir o usuário</li>
        <li>Também haverá um botão para listar os comentários feitos por aquele usuário, e os comentários denunciados ficam destacados em vermelho (o comentário denunciado será clicável e levará para
            <a href="commentComplaint.php">commentComplain.php</a> -> página específica do denúncia comentário)</li>
        <li>Também haverá um botão para listar os Serviços feitos por aquele usuário, e os serviços denunciados ficam destacados em vermelho (o serviço será clicável e levará para
            <a href="../serviceManagement/serviceReport.php">serviceReport.php</a> -> página específica do serviço)</li>
    </ul>
</div>

</body>

</html>