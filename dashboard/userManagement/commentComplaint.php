<?php
require "../assets/getData.php";
$commentsListing = new CommentsListing();
$comments = [];
if (isset($_POST['searchInput'])){
    $comments = $commentsListing->selectSearchedComments($_POST['searchInput'], $_POST['searchParam']);
} else {
    $comments = $commentsListing->selectAllComments();
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

            </li>

            <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed active">
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li class="active"><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li><a href="contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
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
    <h1>Denúncias de comentários</h1>

    <form action="commentComplaint.php" method="post">
        <div class="float-left">
            <label for="searchInput">Pesquisar comentário:</label> <br>
            <input type="text" name="searchInput" <?php if (isset($_POST['searchInput'])) {echo "value = '" . $_POST['searchInput'] . "'";}?>>
            <select name="searchParam" id="searchParam">
                <option value="c.id_comentario" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'c.id_comentario') {echo 'selected';}?>>id do comentário</option>
                <option value="c.id_usuario" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'c.id_usuario') {echo 'selected';}?>>id do usuário</option>
                <option value="u.nome_usuario" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'u.nome_usuario') {echo 'selected';}?>>nome do usuário</option>
                <option value="c.id_servico" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'c.id_servico') {echo 'selected';}?>>id do serviço</option>
                <option value="s.nome_servico" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 's.nome_servico') {echo 'selected';}?>>nome do serviço</option>
                <option value="c.desc_comentario" <?php if (isset($_POST['searchParam']) and $_POST['searchParam'] == 'c.desc_comentario') {echo 'selected';}?>>comentário</option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-left">Pesquisar</button>
    </form>

    <div class="clearfix"></div>

    <div class="row my-2">
        <div class="col-md-12 col-lg-10">
            <?php foreach ($comments as $comment) {?>
                <div class="listDiv row my-3" onclick="redirecionaPagina('comment.php', <?=$comment['id_comentario']?>)">
                    <div class="col-md-2 mb-3 mb-sm-0">
                        <div class="text-center">Id comentário:</div>
                        <div class="text-center font-weight-bold"><?=$comment['id_comentario']?></div>
                    </div>
                    <div class="col-md-2 mb-3 mb-sm-0">
                        <div>Feito pelo usuário</div>
                        <div class="font-weight-bold"><?=$comment['nome_usuario']?> (id <?=$comment['id_usuario']?>)</div>
                    </div>
                    <div class="col-md-2 mb-3 mb-sm-0">
                        <div class="">Feito no serviço</div>
                        <div class="font-weight-bold"><?=$comment['nome_servico']?> (id <?=$comment['id_servico']?>)</div>
                    </div>
                    <div class="col-md-4 mb-3 mb-sm-0">
                        <div>Comentário</div>
                        <div class="font-weight-bold allowTextOverflow"> <?=$comment['desc_comentario']?></div>
                    </div>
                    <div class="col-md-2 mb-3 mb-sm-0">
                        <div class="text-center">Qnt denúncias</div>
                        <div class="font-weight-bold text-center"> <?=$commentsListing->getQntComplains($comment['id_comentario'])?></div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>

</body>

</html>