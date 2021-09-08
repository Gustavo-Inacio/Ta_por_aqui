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

            $('.listDiv').on('click', ()=>{
                location.href = "comment.php"
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
            </ul>
        </ul>
    </div>
</div>

<!-- paginas -->
<div class="main" id="pagina">
    <h2>Denúncias de comentários - comentário do Natan (1)</h2>

    <a href="commentComplaint.php"> <i class="fas fa-arrow-left"></i> voltar </a>

    <table class="table table-hover mt-3" style="max-width: 900px">
        <thead class="thead-dark">
        <tr>
            <th colspan="2" class="text-center">Informações gerais do comentário</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Id do comentário:</th>
            <td><?=$_GET['id']?></td>
        </tr>
        <tr>
            <th>Usuário que comentou:</th>
            <td>Natan Rocha</td>
        </tr>
        <tr>
            <th>Serviço avaliado:</th>
            <td>Pintura de parede (id 1)</td>
        </tr>
        <tr>
            <th>Nota da avaliação:</th>
            <td>4.3</td>
        </tr>
        <tr>
            <th>Data do comentário:</th>
            <td>01/01/2001</td>
        </tr>
        <tr>
            <th>status:</th>
            <td>exibido</td>
        </tr>
        <tr>
            <th>Quantidade de denúncias:</th>
            <td>2</td>
        </tr>
        <tr>
            <th>comentário:</th>
            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus blanditiis culpa cum dolor enim explicabo, fugit iure iusto magni maiores neque, quos ratione rem repudiandae sequi ullam unde, velit voluptatibus?</td>
        </tr>
        </tbody>
    </table>

    <button type="button" class="btn btn-primary d-block" data-toggle="collapse" data-target="#complains"
            aria-expanded="false" aria-controls="complains">Listar denúncias desse comentário
    </button>

    <div class="collapse mt-3" id="complains">
        <div class="row">
            <div class="col-md-4 mt-md-0 mt-3">
                <table class="table table-hover table-sm mt-3" style="max-width: 900px">
                    <thead class="table-danger">
                    <tr>
                        <th colspan="2" class="text-center">Detalhes da denúncia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Id da denúncia:</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Usuário que denunciou</th>
                        <td>Carlos Barbosa (id 7)</td>
                    </tr>
                    <tr>
                        <th>Motivo:</th>
                        <td>spam de comentário</td>
                    </tr>
                    <tr>
                        <th>Descrição</th>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque dolorem earum ex explicabo minus quam repellendus. Ad animi aspernatur eaque enim eum, facilis, impedit nobis placeat quam qui quisquam rem!</td>
                    </tr>
                    <tr>
                        <th>Data:</th>
                        <td>01/01/2001</td>
                    </tr>
                    <tr>
                        <th>status:</th>
                        <td>não resolvido</td>
                    </tr>
                    <tr>
                        <th>Marcar como:</th>
                        <td> <button class="btn btn-secondary btn-sm">Em análise</button> | <button class="btn btn-success btn-sm">Resolvido</button> </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4 mt-md-0 mt-3">
                <table class="table table-hover table-sm mt-3" style="max-width: 900px">
                    <thead class="table-danger">
                    <tr>
                        <th colspan="2" class="text-center">Detalhes da denúncia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Id da denúncia:</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Usuário que denunciou</th>
                        <td>Carlos Barbosa (id 7)</td>
                    </tr>
                    <tr>
                        <th>Motivo:</th>
                        <td>spam de comentário</td>
                    </tr>
                    <tr>
                        <th>Descrição</th>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque dolorem earum ex explicabo minus quam repellendus. Ad animi aspernatur eaque enim eum, facilis, impedit nobis placeat quam qui quisquam rem!</td>
                    </tr>
                    <tr>
                        <th>Data:</th>
                        <td>01/01/2001</td>
                    </tr>
                    <tr>
                        <th>status:</th>
                        <td>não resolvido</td>
                    </tr>
                    <tr>
                        <th>Marcar como:</th>
                        <td> <button class="btn btn-secondary btn-sm">Em análise</button> | <button class="btn btn-success btn-sm">Resolvido</button> </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <table class="table table-hover table-sm mt-3" style="max-width: 900px">
                    <thead class="table-danger">
                    <tr>
                        <th colspan="2" class="text-center">Detalhes da denúncia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Id da denúncia:</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Usuário que denunciou</th>
                        <td>Carlos Barbosa (id 7)</td>
                    </tr>
                    <tr>
                        <th>Motivo:</th>
                        <td>spam de comentário</td>
                    </tr>
                    <tr>
                        <th>Descrição</th>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque dolorem earum ex explicabo minus quam repellendus. Ad animi aspernatur eaque enim eum, facilis, impedit nobis placeat quam qui quisquam rem!</td>
                    </tr>
                    <tr>
                        <th>Data:</th>
                        <td>01/01/2001</td>
                    </tr>
                    <tr>
                        <th>status:</th>
                        <td>não resolvido</td>
                    </tr>
                    <tr>
                        <th>Marcar como:</th>
                        <td> <button class="btn btn-secondary btn-sm">Em análise</button> | <button class="btn btn-success btn-sm">Resolvido</button> </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>

</html>