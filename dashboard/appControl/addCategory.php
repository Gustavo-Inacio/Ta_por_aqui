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
            $('#appControl').collapse('show')
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

            <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="../userManagement/userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li><a href="../userManagement/userBan.php"><i class="fa fa-angle-right"></i> Banimentos de usuários</a></li>
                <li><a href="../userManagement/commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="../userManagement/contact.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
                <li><a href="../serviceManagement/serviceBan.php"><i class="fa fa-angle-right"></i> Banimentos de serviços</a></li>
                <li><a href="../serviceManagement/serviceComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de serviços</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#appControl" class="collapsed active">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li class="active"><a href="addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
                <li><a href="addReason.php"><i class="fa fa-angle-right"></i> Adicionar motivos</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Adicionar categoria</h1>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consequatur excepturi quae sit vitae! A ab aperiam commodi delectus error laboriosam libero obcaecati quis ullam veritatis. Delectus dolores nobis quos!
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aperiam architecto asperiores assumenda consequuntur doloremque ducimus ea eius enim et facere, incidunt maxime, necessitatibus nemo nihil nulla quae sunt, veniam.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad cupiditate error harum impedit laboriosam laudantium, minima nesciunt non quae sunt! Consequuntur deserunt fuga fugit hic impedit officia, perspiciatis quos sequi.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus at aut commodi culpa dolor fugiat impedit itaque laudantium molestias mollitia, nam nemo nisi nulla odio pariatur quae vel vero voluptates!
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam at consequatur cumque dolor, dolores eos eum excepturi, fugit illum ipsam libero magnam nobis odit perferendis repudiandae sequi sit vitae!
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, ad animi deleniti, distinctio doloribus dolorum ex facere hic natus neque nesciunt odit pariatur provident quibusdam quis tempora tempore totam voluptatibus?
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque nisi officia quod ratione sequi tempora, voluptatem. Aperiam aspernatur commodi, doloribus fugiat iusto, molestias praesentium saepe sequi sunt totam unde voluptatibus.
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab dicta dolor doloribus eligendi et, fugit libero molestias neque, officia placeat provident quos recusandae rerum, sequi tempore unde voluptatem voluptates voluptatibus!
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores atque, cumque doloribus ducimus numquam officiis praesentium quaerat quisquam recusandae sint. Architecto at dolor explicabo illum perspiciatis rem ut voluptate voluptatum!
    </p>
</div>

</body>

</html>