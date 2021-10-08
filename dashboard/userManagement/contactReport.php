<?php
require "../assets/getData.php";

session_start();
if (empty($_SESSION['idAdm']) || empty($_SESSION['emailAdm']) || empty($_SESSION['senhaAdm'])){
    header('location:../index.php');
    exit();
}

$contactListing = new ContactListing();
$contacts = [];
if (isset($_GET['contactReason']) || isset($_GET['contactStatus'])){
    $contacts = $contactListing->selectFilteredContacts($_GET['contactReason'], $_GET['contactStatus']);
} else if (isset($_GET['searchInput'])){
    $contacts = $contactListing->selectSearchedContacts($_GET['searchInput'], $_GET['searchParam']);
} else {
    $contacts = $contactListing->selectAllContacts();
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

        function redirecionaPagina(pag, param){
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
                <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
                <li><a href="userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
                <li><a href="commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
                <li class="active"><a href="contactReport.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#gerenciamentoServicos" class="collapsed">
                <div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
            </li>
            <ul class="sub-menu collapse" id="gerenciamentoServicos">
                <li><a href="../serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
            </ul>

            <li data-bs-toggle="collapse" data-bs-target="#appControl" class="collapsed">
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
    <h1>Fale conosco</h1>

    <form action="contactReport.php" method="get">
        <div class="float-start">
            <label class="me-2" for="contactReason">Filtrar por motivo: </label> <br>
            <select class="me-2" name="contactReason" id="contactReason">
                <option value="">Todos os serviços</option>
                <option value="1" <?php if (isset($_GET['contactReason']) and $_GET['contactReason'] == 1) {echo 'selected';}?>>elogios</option>
                <option value="2" <?php if (isset($_GET['contactReason']) and $_GET['contactReason'] == 2) {echo 'selected';}?>>sugestões</option>
                <option value="3" <?php if (isset($_GET['contactReason']) and $_GET['contactReason'] == 3) {echo 'selected';}?>>reclamações</option>
                <option value="4" <?php if (isset($_GET['contactReason']) and $_GET['contactReason'] == 4) {echo 'selected';}?>>problemas/bugs</option>
                <option value="6" <?php if (isset($_GET['contactReason']) and $_GET['contactReason'] == 6) {echo 'selected';}?>>contestação de banimento</option>
                <option value="5" <?php if (isset($_GET['contactReason']) and $_GET['contactReason'] == 5) {echo 'selected';}?>>outros motivos</option>
            </select>
        </div>

        <div class="float-start">
            <label class="me-2" for="contactStatus">Filtrar por status: </label> <br>
            <select class="me-2" name="contactStatus" id="contactStatus">
                <option value="">Todos os serviços</option>
                <option value="0" <?php if (isset($_GET['contactStatus']) and $_GET['contactStatus'] == 0) {echo 'selected';}?>>Não visto</option>
                <option value="1" <?php if (isset($_GET['contactStatus']) and $_GET['contactStatus'] == 1) {echo 'selected';}?>>ignorado</option>
                <option value="2" <?php if (isset($_GET['contactStatus']) and $_GET['contactStatus'] == 2) {echo 'selected';}?>>resolvendo</option>
                <option value="3" <?php if (isset($_GET['contactStatus']) and $_GET['contactStatus'] == 3) {echo 'selected';}?>>resolvido</option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-start">Aplicar filtro</button>
    </form>

    <div class="clearfix my-3"></div>

    <form action="contactReport.php" method="get">
        <div class="float-start">
            <label for="searchInput">Pesquisar contato:</label> <br>
            <input class="me-2" type="text" name="searchInput" <?php if (isset($_GET['searchInput'])) {echo "value = '" . $_GET['searchInput'] . "'";}?>>
            <select class="me-2" name="searchParam" id="searchParam">
                <option value="id_contato" <?php if (isset($_GET['searchParam']) and $_GET['searchParam'] == 'id_contato') {echo 'selected';}?>>id do contato</option>
                <option value="nome_contato" <?php if (isset($_GET['searchParam']) and $_GET['searchParam'] == 'nome_contato') {echo 'selected';}?>>nome</option>
                <option value="email_contato" <?php if (isset($_GET['searchParam']) and $_GET['searchParam'] == 'email_contato') {echo 'selected';}?>>email</option>
                <option value="fone_contato" <?php if (isset($_GET['searchParam']) and $_GET['searchParam'] == 'fone_contato') {echo 'selected';}?>>telefone</option>
                <option value="msg_contato" <?php if (isset($_GET['searchParam']) and $_GET['searchParam'] == 'msg_contato') {echo 'selected';}?>>mensagem</option>
            </select>
        </div>
        <br>
        <button type="submit" class="float-start">Pesquisar</button>
    </form>

    <div class="clearfix my-3"></div>

    <div class="row my-2">
        <div class="col-md-12 col-lg-10">
            <?php foreach ($contacts as $contact) {?>
                <div class="listDiv row my-3" onclick="redirecionaPagina('contact.php', <?=$contact['id_contato']?>)">
                    <div class="col-sm-2 mb-3 mb-sm-0">
                        <div class="text-center">Id contato:</div>
                        <div class="text-center font-weight-bold"><?=$contact['id_contato']?></div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div>Feito pelo usuário</div>
                        <div class="font-weight-bold"><?=$contact['email_contato']?></div>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div>Mensagem</div>
                        <div class="font-weight-bold allowTextOverflow"><?=$contact['msg_contato']?></div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <?php
                            $tmpMotivo = "";
                        switch ($contact['motivo_contato']) {
                            case 1:
                                $tmpMotivo = "Elogio";
                                break;
                            case 2:
                                $tmpMotivo = "Sugestão";
                                break;
                            case 3:
                                $tmpMotivo = "Reclamação";
                                break;
                            case 4:
                                $tmpMotivo = "Problema/bug";
                                break;
                            case 5:
                                $tmpMotivo = "Outro motivo";
                                break;
                            case 6:
                                $tmpMotivo = "Contestação de banimento";
                                break;
                        }
                        ?>
                        <div class="text-center">Motivo contato</div>
                        <div class="font-weight-bold text-center"><?=$tmpMotivo?> (<?=$contact['motivo_contato']?>)</div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>

</body>

</html>