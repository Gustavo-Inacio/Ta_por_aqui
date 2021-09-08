<?php
//itens por página e página atual
$itensPerPage = 10;
$currentPage = intval($_GET['pag']);

/*
 * pegar itens no banco pelo mysql com limit
 * "SELECT * FROM tabela LIMIT $currentPage, $itensPerPage"
*/

/*
 * pegar quantidade total de itens do banco de dados
 * "SELECT * FROM tabela" -> numrows
*/

/*
 * pegar quantidade total de páginas que terá
 * ceil(quantidade total de produtos / $itensPerPage) -> arredondar resultado para cima
 */

/*
 * Na páginação do bootstrap criar um loop pra fazer o número de páginas
 */

//https://youtu.be/hPsYf0BeHKk