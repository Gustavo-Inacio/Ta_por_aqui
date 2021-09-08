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
    <h2>Relatório de usuários - Natan Barbosa (3)</h2>
    <a href="userReport.php"> <i class="fas fa-arrow-left"></i> voltar </a> <br>

    <div class="row mt-5">
        <div class="col-md-6">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-center">Informações importantes do usuário</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="2"><img src="../../assets/images/users/no_picture.jpg" alt="imagem do usuário"
                                         class="userPicture"></td>
                </tr>
                <tr>
                    <th>Id do usuário:</th>
                    <td>3</td>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <td>Natan Rocha</td>
                </tr>
                <tr>
                    <th>Email cadastrado:</th>
                    <td>emaildousuario@gmail.com</td>
                </tr>
                <tr>
                    <th>Senha:</th>
                    <td>SucoDeLaranja123</td>
                </tr>
                <tr>
                    <th>Classificação:</th>
                    <td>prestador</td>
                </tr>
                <tr>
                    <th>Nota média:</th>
                    <td>4/5</td>
                </tr>
                <tr>
                    <th>Status:</th>
                    <td>Usuário ativo</td>
                </tr>
                <tr>
                    <th>Quantidade de denúncias:</th>
                    <td>0</td>
                </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-danger btn-lg mt-3">Banir usuário</button>
        </div>

        <div class="col-md-6 mt-3 mt-md-0">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-center">Outras informações do usuário</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Telefone de contato:</th>
                    <td>(11) 991852415</td>
                </tr>
                <tr>
                    <th>Data de nascimento:</th>
                    <td>01/01/2001</td>
                </tr>
                <tr>
                    <th>Sexo:</th>
                    <td>Masculino</td>
                </tr>
                <tr>
                    <th>Localização:</th>
                    <td>SP, São Bernardo</td>
                </tr>
                <tr>
                    <th>Classificação:</th>
                    <td>prestador</td>
                </tr>
                <tr>
                    <th>Site inserido:</th>
                    <td><a href="www.kekw.com">www.kekw.com</a></td>
                </tr>
                <tr>
                    <th>Descrição inserida:</th>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto beatae cumque cupiditate
                        fugit perferendis voluptate. Aliquam atque, distinctio error excepturi id maxime molestiae nulla
                        officia perferendis quis rerum sequi velit.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr>

    <h4>Ações</h4>
    <button type="button" class="btn btn-primary d-block" data-toggle="collapse" data-target="#userComments"
            aria-expanded="false" aria-controls="userComments">Listar comentários do usuário
    </button>
    <div class="collapse mt-3" id="userComments">
        <div class="row my-2">
            <div class="col-md-12 col-lg-10">
                <div class="listDiv commentDiv row my-3" onclick="redirecionaPagina('comment.php', 1)">
                    <div class="col-sm-2 mb-3 mb-sm-0">
                        <div class="text-center">Id comentário:</div>
                        <div class="text-center font-weight-bold">1</div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div>Feito pelo usuário</div>
                        <div class="font-weight-bold">Natan Barbosa (id 4)</div>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div>Comentário</div>
                        <div class="font-weight-bold allowTextOverflow">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi atque autem distinctio explicabo fuga impedit, in neque officia. Accusamus consequatur culpa deserunt ea impedit iure modi numquam perferendis quis, voluptatibus?</div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="text-center">Quantidade denúncias</div>
                        <div class="font-weight-bold text-center">5</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-12 col-lg-10">
                <div class="listDiv commentDiv row my-3" onclick="redirecionaPagina('comment.php', 2)">
                    <div class="col-sm-2 mb-3 mb-sm-0">
                        <div class="text-center">Id comentário:</div>
                        <div class="text-center font-weight-bold">2</div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div>Feito pelo usuário</div>
                        <div class="font-weight-bold">Natan Barbosa (id 4)</div>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div>Comentário</div>
                        <div class="font-weight-bold allowTextOverflow">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi atque autem distinctio explicabo fuga impedit, in neque officia. Accusamus consequatur culpa deserunt ea impedit iure modi numquam perferendis quis, voluptatibus?</div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="text-center">Quantidade denúncias</div>
                        <div class="font-weight-bold text-center">5</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-12 col-lg-10">
                <div class="listDiv commentDiv row my-3" onclick="redirecionaPagina('comment.php', 3)">
                    <div class="col-sm-2 mb-3 mb-sm-0">
                        <div class="text-center">Id comentário:</div>
                        <div class="text-center font-weight-bold">3</div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div>Feito pelo usuário</div>
                        <div class="font-weight-bold">Natan Barbosa (id 4)</div>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div>Comentário</div>
                        <div class="font-weight-bold allowTextOverflow">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi atque autem distinctio explicabo fuga impedit, in neque officia. Accusamus consequatur culpa deserunt ea impedit iure modi numquam perferendis quis, voluptatibus?</div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="text-center">Quantidade denúncias</div>
                        <div class="font-weight-bold text-center">5</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary d-block mt-4" data-toggle="collapse" data-target="#userServices"
            aria-expanded="false" aria-controls="userServices">Listar serviços do usuário
    </button>
    <div class="collapse mt-3" id="userServices">
        <div class="row my-2">
            <div class="col-md-12 col-lg-10">
                <div class="listDiv row my-3" onclick="redirecionaPagina('../serviceManagement/service.php', 1)">
                    <div class="col-sm-1 mr-2 mb-3 mb-sm-0">
                        <img src="../../assets/images/service_images/1629286141611ceefd50e10.jpg" alt="imagem do serviço" class="userPicture">
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span>Pintura de parede (id 1)</span> <br>
                        <span class="text-secondary">Natan Barbosa (id 3)</span>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <span>Serviço remoto</span> <br>
                        <span class="text-secondary">nota média: 4/5</span>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span class="text-success">Serviço ativo</span> <br>
                        <span>Denúncias: 0</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-12 col-lg-10">
                <div class="listDiv row my-3" onclick="redirecionaPagina('../serviceManagement/service.php', 2)">
                    <div class="col-sm-1 mr-2 mb-3 mb-sm-0">
                        <img src="../../assets/images/service_images/1629286141611ceefd50e10.jpg" alt="imagem do serviço" class="userPicture">
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span>Pintura de parede (id 2)</span> <br>
                        <span class="text-secondary">Natan Barbosa (id 3)</span>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <span>Serviço remoto</span> <br>
                        <span class="text-secondary">nota média: 4/5</span>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span class="text-success">Serviço ativo</span> <br>
                        <span>Denúncias: 0</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-12 col-lg-10">
                <div class="listDiv row my-3" onclick="redirecionaPagina('../serviceManagement/service.php', 3)">
                    <div class="col-sm-1 mr-2 mb-3 mb-sm-0">
                        <img src="../../assets/images/service_images/1629286141611ceefd50e10.jpg" alt="imagem do serviço" class="userPicture">
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span>Pintura de parede (id 2)</span> <br>
                        <span class="text-secondary">Natan Barbosa (id 3)</span>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <span>Serviço remoto</span> <br>
                        <span class="text-secondary">nota média: 4/5</span>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <span class="text-success">Serviço ativo</span> <br>
                        <span>Denúncias: 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>