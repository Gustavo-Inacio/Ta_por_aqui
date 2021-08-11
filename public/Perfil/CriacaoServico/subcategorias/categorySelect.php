<?php
    require "../../../../logic/DbConnection.php";
    $con = new DbConnection();
    $con = $con->connect();

    //query pesquisar categorias no banco de dados
    $query = "SELECT * FROM categorias";
    $stmt = $con->query($query);
    $listaCategorias = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="modal-header">
    <h5 class="modal-title">Categorias disponíveis</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <?php foreach ($listaCategorias as $i => $categoria) {
        if($i === count($listaCategorias) - 1) {
    ?>
            <div class="masterCategory d-flex last" onclick="loadCategory('subcategorias.php?id_categoria=<?=$categoria->id_categoria?>')"> <span><?=$categoria->nome_categoria?></span> <span class="ml-auto"> <i class="fas fa-arrow-right"></i> </span> </div>
        <?php } else {?>
            <div class="masterCategory d-flex" onclick="loadCategory('subcategorias.php?id_categoria=<?=$categoria->id_categoria?>')"> <span><?=$categoria->nome_categoria?></span> <span class="ml-auto"> <i class="fas fa-arrow-right"></i> </span> </div>
        <?php
        }
    }?>
</div>