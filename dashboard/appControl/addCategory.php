<?php
require "../assets/getData.php";

session_start();
if (empty($_SESSION['idAdm']) || empty($_SESSION['emailAdm']) || empty($_SESSION['senhaAdm'])){
    header('location:../index.php');
    exit();
}

$createCategories = new AppControl();
$operationMsg = "";
if (isset($_POST['masterCategories'])){
    $operationMsg = $createCategories->addMasterCategories($_POST['masterCategories']);
}

if (isset($_POST['masterCategoryForSub']) && isset($_POST['subCategories'])){
    $operationMsg = $createCategories->addSubCategories($_POST['subCategories'], $_POST['masterCategoryForSub']);
}
$categories = $createCategories->getCategories();
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
                <a href="../analisys.php"><i class="fas fa-chart-bar sidebar-icon"></i> Estatísticas do site</a>
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
                <li><a href="addComplainReason.php"><i class="fa fa-angle-right"></i> Adicionar denúncias motivos</a></li>
                <li><a href="addExitReason.php"><i class="fa fa-angle-right"></i> Adicionar saída motivos</a></li>
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h1>Adicionar categoria</h1>

    <?php if ($operationMsg !== "") { ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <span><?=$operationMsg?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }?>

    <div id="addMasterCategoryDiv" class="my-4">
        <h3>Adicionar categoria mestre</h3>
        <form action="addCategory.php" method="post">
            <label for="masterCategories">Digite as categorias mestres que serão Adicionadas </label> <br>
            <textarea name="masterCategories" id="masterCategories" cols="50" rows="4" required placeholder="escreva a(s) categoria(s) e caso haja mais de uma separe por vírgula. Exemplo: Informática, Serviços domésticos, Limpeza, Organização escolar"></textarea>
            <br>
            <button type="submit">Adicionar</button>
        </form>
    </div>

    <hr>

    <div id="addSubCategoryDiv" class="my-4">
        <h3>Adicionar subcategoria</h3>
        <form action="addCategory.php" method="post">
            <label for="masterCategoryForSub">Escolha a categoria mestre para qual as subcategorias vão pertencer: </label>
            <br>
            <select name="masterCategoryForSub" id="masterCategoryForSub" required>
                <?php foreach ($categories as $category) {?>
                    <option value="<?=$category['id_categoria']?>"><?=$category['nome_categoria']?></option>
                <?php }?>
            </select>
            <br> <br>

            <label for="subCategories">Digite as subcategorias mestres que serão Adicionadas</label> <br>
            <textarea name="subCategories" id="subCategories" cols="50" rows="4" required placeholder="escreva a(s) categoria(s) e caso haja mais de uma separe por vírgula. Exemplo: Informática, Serviços domésticos, Limpeza, Organização escolar"></textarea> <br>
            <button type="submit">Adicionar</button>
        </form>

    </div>
</div>
</body>
</html>