//habilitar popover
$(function () {
    $('[data-toggle="popover"]').popover()
})

//mascara do valor fixo
$('#valorFixo').mask('##0,00', {reverse: true});