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

    <script src="addCategory.js"></script>
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

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#appControl" class="collapsed active">
                <div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="appControl">
                <li class="active"><a href="addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Adicionar categoria</h1>

    <div id="addMasterCategoryDiv" class="my-4">
        <h3>Adicionar categoria mestre</h3>
        <form action="">
            <label for="qntMasters">Digite as categorias mestres que serão Adicionadas </label> <br>
            <textarea name="categoriasMestre" id="masterCategories" cols="50" rows="4" placeholder="escreva a(s) categoria(s) e caso haja mais de uma separe por vírgula e espaço. Exemplo: Informática, Serviços domésticos, Limpeza, Organização escolar"></textarea>
            <br>
            <button type="button">Adicionar</button>
        </form>
    </div>

    <hr>

    <div id="addSubCategoryDiv" class="my-4">
        <h3>Adicionar subcategoria</h3>
        <form action="">
            <label for="masterCategoriesForSub">Escolha a categoria mestre para qual as subcategorias vão pertencer: </label>
            <br>
            <select name="categoriaMestreDaSub" id="masterCategoriesForSub">
                <option value="">Selecionar categoria mastre</option>
                <option value="">Cat 1</option>
                <option value="">Cat 1</option>
                <option value="">Cat 1</option>
                <option value="">Cat 1</option>
                <option value="">Cat 1</option>
            </select>
            <br> <br>

            <label for="subCategories">Digite as subcategorias mestres que serão Adicionadas</label> <br>
            <textarea name="subCategorias" id="subCategories" cols="50" rows="4" placeholder="escreva a(s) categoria(s) e caso haja mais de uma separe por vírgula e espaço. Exemplo: Informática, Serviços domésticos, Limpeza, Organização escolar"></textarea> <br>
            <button type="button">Adicionar</button>
        </form>

    </div>
</div>

</body>

</html>