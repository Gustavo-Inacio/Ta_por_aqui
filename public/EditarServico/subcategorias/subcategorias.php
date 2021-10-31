<?php
    require "../../../logic/DbConnection.php";
    $con = new DbConnection();
    $con = $con->connect();

    //nome da categoria mestre
    $query = "SELECT nome_categoria FROM categorias where id_categoria = " . $_POST['requested_category'];
    $stmt = $con->query($query);
    $categoriaMestre = $stmt->fetch(PDO::FETCH_OBJ);

    //query pesquisar categorias no banco de dados
    $query = "SELECT * FROM subcategorias where id_categoria = " .$_POST['requested_category'] . " ORDER BY nome_subcategoria";
    $stmt = $con->query($query);
    $listaSubcategorias = $stmt->fetchAll(PDO::FETCH_OBJ);

    $currentSubCat = [];
    if ($_POST['requested_category'] == $_POST['currentServiceCategory']){
        $query = "SELECT id_subcategoria from servico_categorias WHERE id_servico = {$_POST['serviceId']}";
        $currentSubCat = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<div class="modal-header">
    <span class="returnArrow me-3" onclick="backToCatSelection(<?=$_POST['currentServiceCategory'] . ', ' . $_POST['serviceId']?>)"> <i class="fas fa-arrow-left"></i> </span>

    <h5 class="modal-title"> <?=$categoriaMestre->nome_categoria?> </h5>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <?php foreach ($listaSubcategorias as $key => $subcategoria) {?>
        <div class="subCategory"> <input type="checkbox" class="checkCategory" name="subcategoria[]" id="subcategoria<?=$subcategoria->id_subcategoria?>" value="<?=$subcategoria->id_subcategoria?>" <?php if ((isset($currentSubCat[0]) && $currentSubCat[0]['id_subcategoria'] == $subcategoria->id_subcategoria) || (isset($currentSubCat[1]) && $currentSubCat[1]['id_subcategoria'] == $subcategoria->id_subcategoria) || (isset($currentSubCat[2]) && $currentSubCat[2]['id_subcategoria'] == $subcategoria->id_subcategoria)) {echo 'checked';}?>> <label for="subcategoria<?=$subcategoria->id_subcategoria?>" class="text-dark"> <?=$subcategoria->nome_subcategoria?> </label> </div>
    <?php }?>
</div>

<div class="modal-footer">
    <button type="button" class="mybtn mybtn-complement" data-bs-dismiss="modal">Salvar categorias</button>
</div>