<?php
session_start();

require "editar_servico_brain.php";

$editarServico = new editService($_POST['serviceId']);
$con = $editarServico->getCon();

echo "<pre>";
print_r($_POST);
echo "</pre> <hr>";

echo "<pre>";
print_r($_FILES);
echo "</pre> <hr>";

//Validando possíveis problemas que o banco de dados pode não capturar
#Quantidade de categorias
if( count($_POST['subcategoria']) > 3 || count($_POST['subcategoria']) === 0 ){
    header('Location: ../public/EditarServico/editar_servico.php?erro=quantidade%20invalida%20de%20categorias');
    exit();
}

#Verificando os arquivos enviados
$qntOldImages = isset($_POST['oldImages']) ? count($_POST['oldImages']) : 0;
if ($_FILES['imagens']['error'][0] != 4){
    //imagens > 4
    if( count($_FILES['imagens']['name']) + $qntOldImages > 4 ){
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

//Deletando as iamgens que o usuário escolheu deletar
#selecionando todas as imagens que o serviço tinha antes
$generalImages = [];
$oldImages = $editarServico->getServiceData();
$oldImages = $oldImages['serviceIMG'];
foreach ($oldImages as $img){
    array_push($generalImages, $img['id_imagem']);
}

if ($qntOldImages !== 0){
    #selecionando imagens do post que foram mantidas e guardando em um array
    $keptImages = [];
    foreach ($_POST['oldImages'] as $img){
        array_push($keptImages, $img['id_imagem']);
    }

    #diferença entre os arrays = imagens deletadas
    $deletedImages = array_diff($generalImages, $keptImages);

    echo "<pre>";
    print_r($deletedImages);
    echo "</pre>";

    //deletando o diretório dessas imagens e, em seguida, o diretório delas no BD
    foreach ($deletedImages as $delImg){
        $dirImg = $con->query("SELECT dir_servico_imagem as dir FROM servico_imagens WHERE id_imagem = $delImg")->fetch(PDO::FETCH_OBJ)->dir;
        unlink("../assets/images/users/$dirImg");

        $con->query("DELETE FROM servico_imagens WHERE id_imagem = $delImg");
    }
} else {
    //deletando o diretório dessas imagens e, em seguida, o diretório delas no BD
    foreach ($generalImages as $delImg){
        $dirImg = $con->query("SELECT dir_servico_imagem as dir FROM servico_imagens WHERE id_imagem = $delImg")->fetch(PDO::FETCH_OBJ)->dir;
        unlink("../assets/images/users/$dirImg");

        $con->query("DELETE FROM servico_imagens WHERE id_imagem = $delImg");
    }
}

//Adicionando as novas imagens ao banco
if ($_FILES['imagens']['error'][0] != 4){
    foreach($_FILES['imagens']['tmp_name'] as $i => $tmpFile){
        #pegando extensão
        $extension = pathinfo($_FILES['imagens']['name'][$i], PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        #criando novo nome unico
        $newName = uniqid( time() ) . "." . $extension;

        #referenciando diretório
        $dir = "../assets/images/users/user".$_SESSION['idUsuario']."/service_images/service{$_POST['serviceId']}/";

        #criar pasta do usuário caso não exista
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        #movendo imagem
        if ( @move_uploaded_file($tmpFile, $dir.$newName) ){
            #caso movido com sucesso --> salvar no banco de dados
            $query3 = "INSERT INTO servico_imagens(id_servico, dir_servico_imagem) VALUES (:id_servico, :nome_imagem)";
            $stmt = $con->prepare($query3);
            $stmt->bindValue(":id_servico", $_POST['serviceId']);
            $stmt->bindValue(":nome_imagem", "user".$_SESSION['idUsuario']."/service_images/service{$_POST['serviceId']}/".$newName);
            $stmt->execute();
        }
    }
}

//atualizando categorias do banco de dados
#deletar categorias anteriores
$delquery = "DELETE FROM servico_categorias WHERE id_servico = {$_POST['serviceId']}";
$con->query($delquery);

#trocar pelas novas
//Adicionando as categorias do serviço
$inserquery = "SELECT id_categoria FROM subcategorias WHERE id_subcategoria = {$_POST['subcategoria'][0]}";
$stmt = $con->query($inserquery);
$masterCategory = $stmt->fetch(PDO::FETCH_OBJ)->id_categoria;

foreach ($_POST['subcategoria'] as $subcategoria){
    $query3 = "INSERT INTO servico_categorias(id_servico, id_categoria, id_subcategoria) values (:id_servico, :id_categoria, :id_subcategoria)";
    $stmt = $con->prepare($query3);
    $stmt->bindValue(":id_servico", $_POST['serviceId']);
    $stmt->bindValue(":id_categoria", $masterCategory);
    $stmt->bindValue(":id_subcategoria", $subcategoria);
    $stmt->execute();
}

//Atualizando as informações gerais do serviço
$query = '';
if ($_POST['tipoPagamento'] == 1){
    $query = "UPDATE servicos SET nome_servico = :nome, tipo_servico = :tipo, desc_servico = :desc, orcamento_servico = null, crit_orcamento_servico = 'A definir orçamento'";
} else {
    $query = "UPDATE servicos SET nome_servico = :nome, tipo_servico = :tipo, desc_servico = :desc, orcamento_servico = :orcamento, crit_orcamento_servico = :crit_orcamento";
}

$stmt = $con->prepare($query);
$stmt->bindValue(':nome', $_POST['nome']);
$stmt->bindValue(':tipo', $_POST['tipo']);
$stmt->bindValue(':desc', $_POST['descricao']);
if ($_POST['tipoPagamento'] == 2){
    $stmt->bindValue(':orcamento', $_POST['orcamento']);
    $stmt->bindValue(':crit_orcamento', $_POST['criterio']);
}
$stmt->execute();

header('Location: ../public/EncontrarProfissional/VisualizarServico/visuaizarServico.php?serviceID='.$_POST['serviceId']);