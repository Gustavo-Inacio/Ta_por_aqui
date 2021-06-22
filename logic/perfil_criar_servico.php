<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//Validando possíveis problemas que o banco de dados pode não capturar
#Quantidade de categorias
if( count($_POST['subcategoria']) > 3 || count($_POST['subcategoria']) === 0 ){
    header('Location: ../public/Perfil/CriacaoServico/criar_servico.php?erro=quantidade%20invalida%20de%20categorias');
}

#Verificando os arquivos enviados
if ($_FILES['imagens']['name'][0] !== ""){
    //imagens > 4
    if( count($_FILES['imagens']['name']) > 4 ){
        header('Location: ../public/Perfil/CriacaoServico/criar_servico.php?erro=Excedeu%20o%20numero%20de%20imagens%20permitidas');
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
$orcamento = "";
if($_POST['tipoPagamento'] == 1){
    $orcamento = "A definir orçamento";
} else if($_POST['tipoPagamento'] == 2){
    $orcamento = $_POST['orcamento'] . " " . $_POST['criterio'];
}

#inserindo informações
$query = "INSERT INTO servico(prestador, nome_servico, tipo, descricao, orcamento) values(:prestador, :nome_servico, :tipo, :descricao, :orcamento)";

$stmt = $con->prepare($query);
$stmt->bindValue(":prestador", $_SESSION['idUsuario']);
$stmt->bindValue(":nome_servico", $_POST['nome']);
$stmt->bindValue(":tipo", $_POST['tipo']);
$stmt->bindValue(":descricao", $_POST['descricao']);
$stmt->bindValue(":orcamento", $orcamento);
$stmt->execute();

//Adicionando as categorias do serviço
$ultimo_id_servico = $con->lastInsertId();

$query2 = "SELECT id_categoria FROM subcategorias WHERE id_subcategoria = " . $_POST['subcategoria'][0];
$stmt = $con->query($query2);
$id_categoria_subcategoria = $stmt->fetch(PDO::FETCH_OBJ);

foreach ($_POST['subcategoria'] as $subcategoria){
    $query3 = "INSERT INTO servico_categoria(id_servico, id_categoria, id_subcategoria) values (:id_servico, :id_categoria, :id_subcategoria)";
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
    $dir = "../assets/images/service_images/" . $newName;

    #movendo imagem
    if ( @move_uploaded_file($tmpFile, $dir) ){
        #caso movido com sucesso --> salvar no banco de dados
        $query3 = "INSERT INTO servico_imagens(id_servico, dir_imagem) VALUES (:ultimo_id_servico, :nome_imagem)";
        $stmt = $con->prepare($query3);
        $stmt->bindValue(":ultimo_id_servico", $ultimo_id_servico);
        $stmt->bindValue(":nome_imagem", $newName);
        $stmt->execute();
    }
}

//redirecionando
header('Location: ../public/Perfil/meu_perfil.php');