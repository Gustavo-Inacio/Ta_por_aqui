<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Tá por aqui - Dashboard</title>

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<link rel="stylesheet" href="../assets/bootstrap/bootstrap-4.5.3-dist/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">

		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="../assets/bootstrap/popper.min.js" defer></script>
		<script src="../assets/bootstrap/bootstrap-4.5.3-dist/js/bootstrap.min.js" defer></script>

		<script src="script.js" defer></script>
	</head>

	<body>

		<!-- menu -->
		<div class="nav-side-menu">
		    <div class="brand py-2"><img src="../assets/images/dumb-brand.png" alt="logo"></div>
		    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
		  
		        <div class="menu-list">
		  
		            <ul id="menu-content" class="menu-content collapse out">
		                <li class="active">
		                  <a href="index.php"><i class="fas fa-chart-bar sidebar-icon"></i> Estatísticas do site</a>
		                </li>

						<li>
							<a href="analisys/charts.php"><i class="fas fa-chart-pie sidebar-icon"></i> Gráficos</a>
						</li>
						<li>
							<a href="analisys/webalizer.php"><i class="fas fa-chart-line sidebar-icon"></i> Webalizer</a>
						</li>

		                <li data-toggle="collapse" data-target="#gerenciamentoUsuarios" class="collapsed">
		                    <div class="moreItems"><i class="fas fa-users sidebar-icon"></i> Gerenciamento usuários <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
		                </li>
		                <ul class="sub-menu collapse" id="gerenciamentoUsuarios">
							<li><a href="userManagement/userReport.php"><i class="fa fa-angle-right"></i> Relatório de usuários</a></li>
							<li><a href="userManagement/commentComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de comentários</a></li>
							<li><a href="userManagement/contact.php"><i class="fa fa-angle-right"></i> Fale conosco</a></li>
		                </ul>

						<li data-toggle="collapse" data-target="#gerenciamentoServicos" class="collapsed">
							<div class="moreItems"><i class="fas fa-people-carry sidebar-icon"></i> Gerenciamento serviços <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
						</li>
						<ul class="sub-menu collapse" id="gerenciamentoServicos">
							<li><a href="serviceManagement/serviceReport.php"><i class="fa fa-angle-right"></i> Relatório de serviços</a></li>
							<li><a href="serviceManagement/serviceComplaint.php"><i class="fa fa-angle-right"></i> Denúncias de serviços</a></li>
						</ul>

						<li data-toggle="collapse" data-target="#appControl" class="collapsed">
							<div class="moreItems"><i class="fas fa-cog sidebar-icon"></i> Controle do app <span class="arrow"><i class="fa fa-angle-down"></i></span></div>
						</li>
						<ul class="sub-menu collapse" id="appControl">
							<li><a href="appControl/addCategory.php"><i class="fa fa-angle-right"></i> Adicionar categorias</a></li>
						</ul>
		            </ul>
		     </div>
		</div>

		<!-- paginas -->
		<div class="main" id="pagina">
            <small>obs: as páginas de gerenciamento de usuário e gerenciamento de serviço terão uma barra de pesquisa tipo assim:</small>
            <br>
            <input type="text">
            <select name="" id="">
                <option value="">Campos pesquisáveis</option>
                <option value="">nome</option>
                <option value="">email</option>
                <option value="">mensagem</option>
            </select>
            <button type="button">pesquisar</button>
            <h1>Estatísticas do site</h1> <br>

            <h3>Sobre usuários</h3>
            <ul>
                <li>Quantidade de usuários do site</li>
                <li>Quantidade de prestadores</li>
                <li>Quantidade de clientes</li>
                <li>Média de usuários masculinos</li>
                <li>Média de usuários femininos</li>
                <li>Média de usuários de outros sexos</li>
            </ul>
            <br>
            <h3>Sobre serviços</h3>
            <ul>
                <li>Quantidade de serviços</li>
                <li>Quantidade de serviços banidos/denunciados</li>
                <li>Média de serviços presenciais X remotos</li>
                <li>Média de preço dos serviços con critérios</li>
                <li>Média de notas dos serviços</li>
            </ul>
            <br>
            <h3>Sobre Contratos</h3>
            <ul>
                <li>Média de contratos aceitos X rejeitados</li>
            </ul>
            <br>
            <h3>Top 5 serviços mais acessados</h3>
            <ul>
                <li>Servico 1</li>
                <li>servico 2</li>
                <li>servico 3</li>
                <li>servico 4</li>
                <li>servico 5</li>
            </ul>
            <br>
            <h3>Top 5 categorias mais escolhidas para serviços</h3>
            <ul>
                <li>Categoria 1</li>
                <li>Categoria 2</li>
                <li>Categoria 3</li>
                <li>Categoria 4</li>
                <li>Categoria 5</li>
            </ul>
            <br>
            <h3>Top 5 motivos que fazem o usuário sair da plataforma</h3>
            <ul>
                <li>Categoria 1</li>
                <li>Categoria 2</li>
                <li>Categoria 3</li>
                <li>Categoria 4</li>
                <li>Categoria 5</li>
            </ul>
            <br>
            <h3>Motivos mais comuns de denuncias de serviços</h3>
            <ul>
                <li>Motivo 1</li>
                <li>Motivo 2</li>
                <li>Motivo 3</li>
                <li>Motivo 4</li>
                <li>Motivo 5</li>
            </ul>
            <br>
            <h3>Motivos mais comuns de denuncias de coment´rios</h3>
            <ul>
                <li>Motivo 1</li>
                <li>Motivo 2</li>
                <li>Motivo 3</li>
                <li>Motivo 4</li>
                <li>Motivo 5</li>
            </ul>
            <br>
            <h3>Média de motivos de contato</h3>
            <ul>
                <li>Elogios: ?</li>
                <li>Sugestões: ?</li>
                <li>Reclamações: ?</li>
                <li>Problemas/bugs: ?</li>
                <li>Outro motivo: ?</li>
            </ul>
		</div>

	</body>

</html>