//habilitar popover
$(function () {
    $('[data-toggle="popover"]').popover()
})

//mascara do valor fixo
$('#valorFixo').mask('##0,00', {reverse: true});

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
        }
    } )

    if(isImg){
        //Verificar se possui apenas 4 imagens
        if(inputImage.files.length > 4){
            //limpar imagens caso haja
            document.getElementById('divImgPreview').innerHTML = ""

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
                    tagImg.width = 200
                    tagImg.className = 'imgPreview col-5 m-2 border rounded'

                    //anexando na div designada
                    document.getElementById('divImgPreview').appendChild(tagImg)

                }

                //enviando o valor do input file pro reader.onload
                reader.readAsDataURL(img)
            })
        }
    } else {
        //limpar imagens caso haja
        document.getElementById('divImgPreview').innerHTML = ""

        //mensagem de erro extensão errada
        document.getElementById('imageErrorMsg').innerHTML = "selecione apenas arquivos .png, .jpg ou .jpeg"
    }

}
/*
links uteis
* https://stackoverflow.com/questions/7023457/get-input-type-file-value-when-it-has-multiple-files-selected
* https://stackoverflow.com/questions/3828554/how-to-allow-input-type-file-to-accept-only-image-files
*/