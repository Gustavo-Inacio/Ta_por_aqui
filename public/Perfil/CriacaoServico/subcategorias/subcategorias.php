<?php
    require "../../../../logic/DbConnection.php";
    $con = new DbConnection();
    $con = $con->connect();

    //nome da categoria mestre
    $query = "SELECT nome_categoria FROM categorias where id_categoria = " . $_GET['id_categoria'];
    $stmt = $con->query($query);
    $categoriaMestre = $stmt->fetch(PDO::FETCH_OBJ);

    //query pesquisar categorias no banco de dados
    $query = "SELECT * FROM subcategorias where id_categoria = " . $_GET['id_categoria'] . " ORDER BY nome_subcategoria";
    $stmt = $con->query($query);
    $listaSubcategorias = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="modal-header">
    <span class="returnArrow mr-3" onclick="loadCategory('categorySelect.php')"> <i class="fas fa-arrow-left"></i> </span>

    <h5 class="modal-title"> <?=$categoriaMestre->nome_categoria?> </h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <?php foreach ($listaSubcategorias as $subcategoria) {?>
        <div class="subCategory"> <input type="checkbox" class="checkCategory" name="subcategoria[]" id="subcategoria<?=$subcategoria->id_subcategoria?>" value="<?=$subcategoria->id_subcategoria?>"> <label for="subcategoria<?=$subcategoria->id_subcategoria?>" class="text-dark"> <?=$subcategoria->nome_subcategoria?> </label> </div>
    <?php }?>
</div>

<div class="modal-footer">
    <button type="button" class="mybtn mybtn-complement" data-dismiss="modal">Salvar categorias</button>
</div>