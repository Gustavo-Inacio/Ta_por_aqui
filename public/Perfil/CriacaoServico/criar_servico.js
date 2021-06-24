//habilitar popover
$(function () {
    $('[data-toggle="popover"]').popover()
})

//mascara do valor fixo
$('#orcamento').mask('##0.00', {reverse: true});

//carregar modal de selecionar categorias
$('#categoriesModalContent').load('subcategorias/categorySelect.php')

//carregar categorias
function loadCategory(subcategory){
    $('#categoriesModalContent').load(`subcategorias/${subcategory}`)

    //atualizar o card de confirmação
    createConfirmCard(3)
}

//limitar até 3 categorias e atualizar o card de confirmação
$(document).on('change', '.checkCategory', e => {
    //limitar até 3 categorias
    if ( $('.checkCategory:checked').length > 3 ){
        e.target.checked = false;
    }

    //atualizar o card de confirmação
    createConfirmCard(3)
})

//Mostrar/ esconder as opções de orçamento com média e Colocar/tirar classe required
function toggleOrcamentoComMedia(value) {
    let divOrcamentoComMedia = document.getElementById('divOrcamentoComMedia')
    let orcamento = document.getElementById('orcamento')
    let criterio = document.getElementById('criterio')

    if(value == "" || value == 1){
        //escondendo inputs de valor com média
        divOrcamentoComMedia.classList.add('d-none')

        //removendo classes de required
        orcamento.classList.remove('required')
        criterio.classList.remove('required')
    } else if(value == 2){
        //mostrando inputs de valor com média
        divOrcamentoComMedia.classList.remove('d-none')

        //adicionando classes de required
        orcamento.classList.add('required')
        criterio.classList.add('required')
    }
}

//Tratar imagem
function verifyImage(inputImage){
    //verificar se todos os arquivos são imagens
    let isImg = true
    $(inputImage.files).each( (index, img) => {
        let lowerImg = img.name.toLowerCase()
        let afterDot = lowerImg.lastIndexOf('.') + 1
        let fileExtension = lowerImg.substr(afterDot)

        if(fileExtension !== 'png' && fileExtension !== 'jpg' && fileExtension !== 'jpeg'){
            isImg = false
            inputImage.value = ""
        }
    } )

    if(isImg){
        //Verificar se possui apenas 4 imagens
        if(inputImage.files.length > 4){
            //limpar imagens caso haja
            document.getElementById('divImgPreview').innerHTML = ""

            //escondendo botão de excluir imagens
            document.getElementById('deleteImages').classList.add('d-none')

            //mensagem de erro >4 imagens
            inputImage.value = ""
            document.getElementById('imageErrorMsg').innerHTML = "Você selecionou mais do que 4 imagens"
        } else {
            //TUDO CERTO. EXIBINDO PRÉVIA DAS IMAGENS ESCOLHIDAS
            //limpar imagens e mensagens de erro caso haja
            document.getElementById('imageErrorMsg').innerHTML = ""
            document.getElementById('divImgPreview').innerHTML = ""

            $(inputImage.files).each((index, img) => {
                //Criando elemento html e settando o src com o filereader
                let reader = new FileReader()

                reader.onload = e => {
                    //criando o elemento html
                    let tagImg = document.createElement('img')
                    tagImg.src = e.target.result
                    tagImg.className = 'imgPreview m-2'

                    //anexando na div designada
                    document.getElementById('divImgPreview').appendChild(tagImg)

                }

                //enviando o valor do input file pro reader.onload
                reader.readAsDataURL(img)
            })

            //exibindo aviso dobre a preview das imagens
            document.getElementById('obsImgPreview').classList.remove('d-none')

            //exibindo botão de excluir imagens
            document.getElementById('deleteImages').classList.remove('d-none')
        }
    } else {
        //limpar imagens caso haja
        document.getElementById('divImgPreview').innerHTML = ""

        //escondendo botão de excluir imagens
        document.getElementById('deleteImages').classList.add('d-none')

        //escondendo aviso dobre a preview das imagens
        document.getElementById('obsImgPreview').classList.add('d-none')

        //mensagem de erro extensão errada
        document.getElementById('imageErrorMsg').innerHTML = "selecione apenas arquivos .png, .jpg ou .jpeg"
    }

    if (inputImage.value === ""){
        //escondendo botão de excluir imagens
        document.getElementById('deleteImages').classList.add('d-none')

        //escondendo aviso dobre a preview das imagens
        document.getElementById('obsImgPreview').classList.add('d-none')
    }

}

function removePreviewImages(){
    //limpar input
    document.getElementById('imagens[]').value = ""

    //limpando preview das imagens
    $( document.getElementsByClassName('imgPreview') ).each( (index, img) => {
        img.remove()
    } )

    //escondendo botão de excluir imagens
    document.getElementById('deleteImages').classList.add('d-none')

    //escondendo aviso dobre a preview das imagens
    document.getElementById('obsImgPreview').classList.add('d-none')
}

//Montar card de confirmação
function createConfirmCard(step, value){
    if(step === 1){
        //etapa 1 --> nome do serviço
        document.getElementById('cardServiceName').innerHTML = value

    } else if(step === 2){
        //etapa 2 --> tipo de serviço
        let ServiceType = ""
        if(value !== ""){
            ServiceType = value == 0 ? "remoto" : "presencial"
        }
        document.getElementById('cardServiceType').innerHTML = ServiceType

    } else if(step === 3){
        //etapa 3 --> categoria do serviço
        document.getElementById('cardServiceCategory').innerHTML = ""

        $('.checkCategory:checked').each( (index, checkbox) => {
            if ( $('.checkCategory:checked').length - 1 === index ){
                //sem vírgula no fim
                document.getElementById('cardServiceCategory').innerHTML += $(`label[for="subcategoria${checkbox.value}"]`)[0].innerText
            } else {
                //com vírgula no fim
                document.getElementById('cardServiceCategory').innerHTML += $(`label[for="subcategoria${checkbox.value}"]`)[0].innerText + ", "
            }
        } )

    } else if(step === 4){
        //etapa 4 --> descrição do serviço
        if(value.length < 20){
            document.getElementById('cardServiceDescription').innerHTML = value
        } else{
            document.getElementById('cardServiceDescription').innerHTML = value.substring(0,50) + "..."
        }

    } else if(step === 5){
        //etapa 5 --> pagamento do serviço (orçamento sem média)
        if (value == 1) {
            document.getElementById('cardServicePayment').innerHTML = "A definir orçamento"
        } else if (value == ""){
            document.getElementById('cardServicePayment').innerHTML = ""
        }

    } else if(step === 6){
        //etapa 6 --> pagamento do serviço (orçamento com média)
        document.getElementById('cardServicePayment').innerHTML = $('#orcamento').val() + " " + $('#criterio').val()
    }
}

function createServiceValidation() {
    let valid = true
    let errorMsg = ""
    let errorMsgOutput = document.getElementById('createServiceErrorMsg')

    //nota: já há uma outra função para validar as imagens (caso tenha)
    //validar se há mais que 3 categorias
    let botao = document.getElementById('categorias')

    if ( $('.checkCategory:checked').length === 0) {
        valid = false
        errorMsg = "Selecione ao menos 1 categoria"
        errorMsgOutput.innerText = errorMsg

        //estilizando botão
        botao.classList.add('btn-danger')
        botao.innerHTML = "Escolha a categoria <i class='fas fa-exclamation-circle'></i>"

    } else if( $('.checkCategory:checked').length > 3 ) {
        valid = false
        errorMsg = "Não selecione mais do que 3 categorias"
        errorMsgOutput.innerText = errorMsg

        //estilizando botão
        botao.classList.add('btn-danger')
        botao.innerHTML = "Escolha a categoria <i class='fas fa-exclamation-circle'></i>"
    } else {
        //desestilizando botão
        botao.classList.remove('btn-danger')
        botao.innerHTML = "Escolha a categoria"
    }

    //campos obrigatórios preenchidos
    $('.required').each( (index, input) => {
        if (input.value === ""){
            valid = false
            errorMsg = "Preencha todos os campos obrigatórios";
            input.classList.add('is-invalid')
        } else {
            input.classList.remove('is-invalid')
        }
    } )

    //Enviar ou Error message Output
    valid ? document.getElementById('serviceForm').submit() : errorMsgOutput.innerText = errorMsg

}

function giveUpService(){
    confirm("Você tem certeza que deseja sair? As informações do formulário não serão salvas") ? location.href = "../meu_perfil.php" : "";
}