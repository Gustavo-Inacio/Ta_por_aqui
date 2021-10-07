<?php
session_start();

require "../../logic/DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//selecionando todos os contatos
$query = "SELECT cc.id_chat_contato, cc.id_servico, cc.id_prestador, cc.id_cliente, cc.status_chat_contato, cc.quem_bloqueou_contato, cc.ultima_att_contato, s.nome_servico FROM chat_contatos cc join servicos s on cc.id_servico = s.id_servico where id_prestador = " . $_SESSION['idUsuario'] . " OR id_cliente = " . $_SESSION['idUsuario'] . " ORDER BY cc.ultima_att_contato DESC";
$chatContatos = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);

//selecionando os contatos favoritos
$query = "SELECT cc.id_chat_contato, cc.id_servico, cc.id_prestador, cc.id_cliente, cc.status_chat_contato, cc.ultima_att_contato, s.nome_servico from chat_contatos_favoritos ccf join chat_contatos cc on ccf.id_chat_contato = cc.id_chat_contato join servicos s on cc.id_servico = s.id_servico where id_usuario = " . $_SESSION['idUsuario'] . " ORDER BY cc.ultima_att_contato DESC";
$chatFavoritos = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);

//retornando apenas contatos pesquisados (caso haja pesquisa)
if ((isset($_GET['param']) && $_GET['param'] != '')){
    $param = $_GET['param'];
    //selecionando todos os contatos
    $query = "SELECT cc.id_chat_contato, cc.id_servico, cc.id_prestador, cc.id_cliente, cc.status_chat_contato, cc.quem_bloqueou_contato, cc.ultima_att_contato, s.nome_servico FROM chat_contatos cc join servicos s on cc.id_servico = s.id_servico where (cc.id_prestador = " . $_SESSION['idUsuario'] . " OR cc.id_cliente = " . $_SESSION['idUsuario'] . ") AND s.nome_servico like '%$param%' ORDER BY cc.ultima_att_contato DESC";
    $chatContatos = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

//pegando contato ativo para requisição
$ativo = $_GET['active'] ?? 'nenhumkk';
?>
<head>
    <script src="generalScripts.js"></script>
    <script>
        //estilizando mensagem para desbloquear usuário
        $('.blockMsg').hover(e => {
            $(e.target).html('Desbloquear usuário')
            $(e.target).css({
                'cursor': 'pointer',
                'color': '#0d6efd',
                'text-decoration': 'underline'
            })
        }, e => {
            $(e.target).html('Você bloqueou esse usuário')
            $(e.target).css({
                'cursor': 'inherit',
                'color': '#ff1717',
                'text-decoration': 'none'
            })
        })

        //adaptando mensagem de desbloquear usuário para celular
        if (window.innerWidth < 768){
            $('.blockMsg').html('Você bloqueou esse usuário. Clique nessa mensagem para desbloquear')
        }
    </script>
</head>
<body>
    <?php if (count($chatFavoritos) > 0 && (!isset($_POST['param'])) || isset($_POST['param']) && $_POST['param'] == '') {?>
        <div class="titleGroup <?=count($chatFavoritos) > 0 ? 'd-flex' : 'd-none'?>">
            <h3 class="userSeparatorTitle">Favoritos</h3>
            <div class="separatorLine"></div>
        </div>

        <div class="usersGroup">
            <?php foreach ($chatFavoritos as $chatFavorito){
                //informações do usuário com quem se está falando
                $DestQuery = "";
                $show = "";
                if($chatFavorito['id_prestador'] != $_SESSION['idUsuario']){
                    //eu sou o cliente e serão exibidas as informações do prestador
                    $DestQuery = "SELECT id_usuario, nome_usuario, sobrenome_usuario, imagem_usuario FROM usuarios where id_usuario = " . $chatFavorito['id_prestador'];
                    $show = 0; //prestador
                } else {
                    //eu sou o prestador e serão exibidas as informações do cliente
                    $DestQuery = "SELECT id_usuario, nome_usuario, sobrenome_usuario, imagem_usuario FROM usuarios where id_usuario = " . $chatFavorito['id_cliente'];
                    $show = 1; //cliente
                }
                $destinatario = $con->query($DestQuery)->fetch(PDO::FETCH_ASSOC);

                //pegar o horário ou dia da última mensagem enviada
                $timeQuery = "SELECT hora_mensagem_chat from chat_mensagens where id_chat_contato = {$chatFavorito['id_chat_contato']} ORDER BY id_chat_mensagem DESC LIMIT 1";
                $ultimaMsg = $con->query($timeQuery)->fetch(PDO::FETCH_OBJ);

                if(!$ultimaMsg){
                    $ultimaMsg = $chatFavorito['ultima_att_contato'];
                } else {
                    $ultimaMsg = $ultimaMsg->hora_mensagem_chat;
                }

                $ultimaMsg = new DateTime($ultimaMsg);

                $currentDate = date('Y-m-d', time());
                $isToday = strtotime($ultimaMsg->format('Y-m-d')) === strtotime($currentDate);

                $ultimaMsgTime = null;
                if ($isToday){
                    $ultimaMsgTime = $ultimaMsg->format('H:i');
                } else {
                    $ultimaMsgTime = $ultimaMsg->format('d/m');
                }

                //Pegar quantas mensagens não foram lidas para um chat em específico
                $query = "SELECT count(*) as qnt FROM chat_mensagens WHERE id_chat_contato = {$chatFavorito['id_chat_contato']} AND id_destinatario_usuario = {$_SESSION['idUsuario']} AND mensagem_lida = false";
                $stmt = $con->query($query);
                $qntMsgNaoLida = $stmt->fetch(PDO::FETCH_OBJ)->qnt;
            ?>
                <div class="userDiv row <?=$ativo == $chatFavorito['id_chat_contato'] ? 'active' : ''?>" chatId="<?=$chatFavorito['id_chat_contato']?>" onclick="loadConversation(<?=$chatFavorito['id_chat_contato']?>, <?=$destinatario['id_usuario']?>)">
                    <div class="col-3 col-md-12 col-lg-3 d-flex d-md-none d-xl-flex">
                        <img src="../../assets/images/users/<?=$destinatario['imagem_usuario']?>" alt="Imagem do usuário" class="userImg">
                    </div>
                    <div class="col-7 col-md-8 col-lg-7">
                        <div class="userName"><?=$destinatario['nome_usuario'] . " " . $destinatario['sobrenome_usuario']?></div>
                        <div class="userService"><?=$show === 0 ? $chatFavorito['nome_servico'] : $chatFavorito['nome_servico'] . " (Meu serviço)"?></div>
                    </div>
                    <div class="col-2 col-md-4 col-lg-2 mt-3 mt-lg-0 text-right">
                        <div class="chatTime"><?=$ultimaMsgTime?></div>
                        <div class="chatQntMsg"><?=intval($qntMsgNaoLida) > 0 ? $qntMsgNaoLida : ''?></div>
                    </div>
                </div>
            <?php }?>
        </div>
    <?php }?>

    <div class="titleGroup">
        <?php if(isset($_POST['param']) && $_POST['param'] != '') {
            echo '<h3 class="userSeparatorTitle">Serviços encontrados</h3>';
        } else {
            echo '<h3 class="userSeparatorTitle">Recentes</h3>';
        }?>
        <div class="separatorLine"></div>
    </div>

    <?php if (count($chatContatos) > 0) {
        foreach ($chatContatos as $chatContato){
            if (!isset($_POST['param']) || (isset($_POST['param']) && $_POST['param'] == '')){
                //Pular essa listagem caso o contato seja favorito (e não seja uma pesquisa)
                $query = "SELECT * FROM chat_contatos_favoritos where id_usuario = " . $_SESSION['idUsuario'] . " AND id_chat_contato = " . $chatContato['id_chat_contato'];
                $favoriteChat = $con->query($query)->fetch(PDO::FETCH_ASSOC);
                if ((isset($favoriteChat['id_chat_favorito']))){
                    continue;
                }
            }

            //informações do usuário com quem se está falando
            $DestQuery = "";
            $show = "";
            if($chatContato['id_prestador'] != $_SESSION['idUsuario']){
                //eu sou o cliente e serão exibidas as informações do prestador
                $DestQuery = "SELECT id_usuario, nome_usuario, sobrenome_usuario, imagem_usuario FROM usuarios where id_usuario = " . $chatContato['id_prestador'];
                $show = 0; //prestador
            } else {
                //eu sou o prestador e serão exibidas as informações do cliente
                $DestQuery = "SELECT id_usuario, nome_usuario, sobrenome_usuario, imagem_usuario FROM usuarios where id_usuario = " . $chatContato['id_cliente'];
                $show = 1; //cliente
            }
            $destinatario = $con->query($DestQuery)->fetch(PDO::FETCH_ASSOC);

            //pegar o horário ou dia da última mensagem enviada
            $timeQuery = "SELECT hora_mensagem_chat from chat_mensagens where id_chat_contato = {$chatContato['id_chat_contato']} ORDER BY id_chat_mensagem DESC LIMIT 1";
            $ultimaMsg = $con->query($timeQuery)->fetch(PDO::FETCH_OBJ);

            if(!$ultimaMsg){
                $ultimaMsg = $chatContato['ultima_att_contato'];
            } else {
                $ultimaMsg = $ultimaMsg->hora_mensagem_chat;
            }

            $ultimaMsg = new DateTime($ultimaMsg);

            $currentDate = date('Y-m-d', time());
            $isToday = strtotime($ultimaMsg->format('Y-m-d')) === strtotime($currentDate);

            $ultimaMsgTime = null;
            if ($isToday){
                $ultimaMsgTime = $ultimaMsg->format('H:i');
            } else {
                $ultimaMsgTime = $ultimaMsg->format('d/m');
            }

            //Pegar quantas mensagens não foram lidas para um chat em específico
            $query = "SELECT count(*) as qnt FROM chat_mensagens WHERE id_chat_contato = {$chatContato['id_chat_contato']} AND id_destinatario_usuario = {$_SESSION['idUsuario']} AND mensagem_lida = false";
            $stmt = $con->query($query);
            $qntMsgNaoLida = $stmt->fetch(PDO::FETCH_OBJ)->qnt;
            ?>
            <div class="usersGroup">
                <?php if ($chatContato['status_chat_contato'] == 1) {?>
                    <div class="userDiv row <?=$ativo == $chatContato['id_chat_contato'] ? 'active' : ''?>" chatId="<?=$chatContato['id_chat_contato']?>" onclick="loadConversation(<?=$chatContato['id_chat_contato']?>, <?=$destinatario['id_usuario']?>, '<?=$destinatario['nome_usuario']?>', '<?=$chatContato['nome_servico']?>')">
                        <div class="col-3 col-md-12 col-lg-3 d-flex d-md-none d-xl-flex">
                            <img src="../../assets/images/users/<?=$destinatario['imagem_usuario']?>" alt="Imagem do usuário" class="userImg">
                        </div>
                        <div class="col-7 col-md-8 col-lg-7">
                            <div class="userName"><?=$destinatario['nome_usuario'] . " " . $destinatario['sobrenome_usuario']?></div>
                            <div class="userService"><?=$show === 0 ? $chatContato['nome_servico'] : $chatContato['nome_servico'] . " (Meu serviço)"?></div>
                        </div>
                        <div class="col-2 col-md-4 col-lg-2 mt-3 mt-lg-0 text-right">
                            <div class="chatTime"><?=$ultimaMsgTime?></div>
                            <div class="chatQntMsg"><?=intval($qntMsgNaoLida) > 0 ? $qntMsgNaoLida : ''?></div>
                        </div>
                    </div>
                <?php } else {?>
                    <div class="userDiv row blocked" chatId="<?= $chatContato['id_chat_contato'] ?>">
                        <div class="col-3 col-md-12 col-lg-3 d-flex d-md-none d-xl-flex">
                            <img src="../../assets/images/users/user_blocked.png" alt="Imagem do usuário" class="userImg">
                        </div>
                        <div class="col-9 col-md-12 col-lg-9">
                            <div class="userName"><?= $destinatario['nome_usuario'] . " " . $destinatario['sobrenome_usuario'] ?></div>
                            <div class="userService"><?= $chatContato['nome_servico'] ?></div>
                            <?php if($_SESSION['idUsuario'] == $chatContato['quem_bloqueou_contato']) {?>
                                <div class="blockMsg" onclick="toggleBlockUser(1,<?= $chatContato['id_chat_contato']?>, <?=$_SESSION['idUsuario']?>)">Você bloqueou esse usuário</div>
                            <?php } else {?>
                                <div class="blockedMsg">Você foi bloqueado por esse usuário</div>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>
            </div>
        <?php }
    } else {
        if (isset($_POST['param'])){
            echo "<span class='text-secondary'>Não foi encontrado nenhum serviço com esse nome.</span>";
        } else {
            if ($_SESSION['classificacao'] == 0) {
                echo "<span class='text-secondary'>Você ainda não entrou em contato com ninguém. Para iniciar uma conversa entre em contato com um prestador pela tela de serviço</span>";
            } else {
                echo "<span class='text-secondary'>Você ainda não entrou em contato com ninguém. Para iniciar uma conversa entre em contato com um prestador pela tela de serviço ou espere algum cliente entrar em contato com você.</span>";
            }
        }
    }?>
    <!-- fim listagem de contatos -->
    <input type="hidden" value="<?= $_GET['param'] ?? '' ?>" id="searchParam">
</body>