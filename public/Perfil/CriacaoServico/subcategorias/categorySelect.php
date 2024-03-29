<?php
    require "../../../../logic/DbConnection.php";
    $con = new DbConnection();
    $con = $con->connect();

    //query pesquisar categorias no banco de dados
    $query = "SELECT * FROM categorias ORDER BY nome_categoria";
    $stmt = $con->query($query);
    $listaCategorias = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="modal-header">
    <h5 class="modal-title">Categorias disponíveis</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <?php foreach ($listaCategorias as $i => $categoria) {
        if($i === count($listaCategorias) - 1) {
    ?>
            <div class="masterCategory d-flex last" onclick="loadCategory('subcategorias.php?id_categoria=<?=$categoria->id_categoria?>')"> <span><?=$categoria->nome_categoria?></span> <span class="ms-auto"> <i class="fas fa-arrow-right"></i> </span> </div>
        <?php } else {?>
            <div class="masterCategory d-flex" onclick="loadCategory('subcategorias.php?id_categoria=<?=$categoria->id_categoria?>')"> <span><?=$categoria->nome_categoria?></span> <span class="ms-auto"> <i class="fas fa-arrow-right"></i> </span> </div>
        <?php
        }
    }?>
</div>