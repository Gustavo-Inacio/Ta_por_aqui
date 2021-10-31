<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//Validando possíveis problemas que o banco de dados pode não capturar
#Quantidade de categorias
if( count($_POST['subcategoria']) > 3 || count($_POST['subcategoria']) === 0 ){
    header('Location: ../public/Perfil/CriacaoServico/criar_servico.php?erro=quantidade%20invalida%20de%20categorias');
    exit();
}

#Verificando os arquivos enviados
if ($_FILES['imagens']['name'][0] !== ""){
    //imagens > 4
    if( count($_FILES['imagens']['name']) > 4 ){
        header('Location: ../public/Perfil/CriacaoServico/criar_servico.php?erro=Excedeu%20o%20numero%20de%20imagens%20permitidas');
        exit();
    }

    //não é imagem / imagem grande demais
    foreach ($_FILES['imagens']['type'] as $i => $value){
        if ($value !== "image/jpeg" && $value !== "image/jpg" && $value !== "image/png"){
            header('Location: ../public/Perfil/CriacaoServico/criar_servico.php?erro=Foram%20enviados%20arquivos%20que%20nao%20sao%20imagens');
            exit();
        }

        if($_FILES['imagens']['size'][$i] > 2097152){
            header('Location:../public/Perfil/CriacaoServico/criar_servico.php?erro=Envie%20arquivos%20de%20no%20maximo%202MB');
            exit();
        }
    }
}

//adicionando as informações gerais do serviço no banco de dados

#montando orcamento
$query = "";
if($_POST['tipoPagamento'] == 1){ //orçamento sem critério ("a definir orçamento")
    $query = "INSERT INTO servicos(id_prestador_servico, nome_servico, tipo_servico, desc_servico, crit_orcamento_servico) values(:prestador, :nome_servico, :tipo, :descricao, 'A definir orçamento')";
} else if($_POST['tipoPagamento'] == 2){ //orçamento com critério (tem valor estipulado)
    $query = "INSERT INTO servicos(id_prestador_servico, nome_servico, tipo_servico, desc_servico, orcamento_servico, crit_orcamento_servico) values(:prestador, :nome_servico, :tipo, :descricao, :orcamento_valor, :orcamento_criterio)";
}

#inserindo informações

$stmt = $con->prepare($query);
$stmt->bindValue(":prestador", $_SESSION['idUsuario']);
$stmt->bindValue(":nome_servico", $_POST['nome']);
$stmt->bindValue(":tipo", $_POST['tipo']);
$stmt->bindValue(":descricao", $_POST['descricao']);
if($_POST['tipoPagamento'] == 2){
    $stmt->bindValue(":orcamento_valor", $_POST['orcamento']);
    $stmt->bindValue(":orcamento_criterio", $_POST['criterio']);
}
$stmt->execute();

//Adicionando as categorias do serviço
$ultimo_id_servico = $con->lastInsertId();

$query2 = "SELECT id_categoria FROM subcategorias WHERE id_subcategoria = " . $_POST['subcategoria'][0];
$stmt = $con->query($query2);
$id_categoria_subcategoria = $stmt->fetch(PDO::FETCH_OBJ);

foreach ($_POST['subcategoria'] as $subcategoria){
    $query3 = "INSERT INTO servico_categorias(id_servico, id_categoria, id_subcategoria) values (:id_servico, :id_categoria, :id_subcategoria)";
    $stmt = $con->prepare($query3);
    $stmt->bindValue(":id_servico", $ultimo_id_servico);
    $stmt->bindValue(":id_categoria", $id_categoria_subcategoria->id_categoria);
    $stmt->bindValue(":id_subcategoria", $subcategoria);
    $stmt->execute();
}

//Salvando a imagem e adicionando ao banco de dados
foreach($_FILES['imagens']['tmp_name'] as $i => $tmpFile){
    #pegando extensão
    $extension = pathinfo($_FILES['imagens']['name'][$i], PATHINFO_EXTENSION);
    $extension = strtolower($extension);

    #criando novo nome unico
    $newName = uniqid( time() ) . "." . $extension;

    #referenciando diretório
    $dir = "../assets/images/users/user".$_SESSION['idUsuario']."/service_images/service$ultimo_id_servico/";

    #criar pasta do usuário caso não exista
    if(!file_exists($dir)){
        mkdir($dir, 0777, true);
    }

    #movendo imagem
    if ( @move_uploaded_file($tmpFile, $dir.$newName) ){
        #caso movido com sucesso --> salvar no banco de dados
        $query3 = "INSERT INTO servico_imagens(id_servico, dir_servico_imagem) VALUES (:ultimo_id_servico, :nome_imagem)";
        $stmt = $con->prepare($query3);
        $stmt->bindValue(":ultimo_id_servico", $ultimo_id_servico);
        $stmt->bindValue(":nome_imagem", "user".$_SESSION['idUsuario']."/service_images/service$ultimo_id_servico/".$newName);
        $stmt->execute();
    }
}

//redirecionando
header('Location: ../public/Perfil/meu_perfil.php');