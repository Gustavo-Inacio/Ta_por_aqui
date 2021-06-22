//preenchendo fake input com placeholder
if(document.getElementById('showUserSite').innerText === ""){
    document.getElementById('showUserSite').innerText = "Caso tenha, insira seu site ou porfólio online"
    document.getElementById('showUserSite').style.color = "#6c757d"
}

//permitir que o usuário clique nos botões de salvar e cancelar e edite seu perfil
function changeButtonColor(){
    let saveButton = document.getElementById("buttonSave")
    let cancelButton = document.getElementById("buttonCancel")

    saveButton.className = 'saveEdit'
    saveButton.disabled = ''
    cancelButton.className = 'cancelEdit'
    cancelButton.disabled = ''

    document.getElementById('buttonEdit').classList.add('d-none')
    document.getElementById('showUserSite').classList.add('d-none')
    document.getElementById('userSite').classList.remove('d-none')

    let name = document.getElementById("userName")
    let lastName = document.getElementById("userLastName")
    let cell = document.getElementById("userCell")
    let email = document.getElementById("userEmail")
    let site = document.getElementById("userSite")
    let description = document.getElementById("userDescription")

    name.removeAttribute('readonly')
    name.style.color = 'black'
    name.focus()

    lastName.removeAttribute('readonly')
    lastName.style.color = 'black'

    cell.removeAttribute('readonly')
    cell.style.color = 'black'

    email.removeAttribute('readonly')
    email.style.color = 'black'

    site.removeAttribute('readonly')
    site.style.color = 'black'

    description.removeAttribute('readonly')
    description.style.color = 'black'

    //aplicando mascara jQuey no input celular
    $(cell).mask('(00) 00000-0000');
}

//editar o nome das redes sociais
function editaRedes(){
    let instagram = document.getElementById('instagram')
    let facebook = document.getElementById('facebook')
    let twitter = document.getElementById('twitter')
    let botaoEditar = document.getElementById('socialMediaEdit')
    let botaoSalvar = document.getElementById('btnSalvarRedes')
    let botaoCancelar = document.getElementById('btnCancelarRedes')

    botaoEditar.className = 'd-none'
    botaoSalvar.classList.remove('d-none')
    botaoCancelar.classList.remove('d-none')

    instagram.removeAttribute('readonly')
    facebook.removeAttribute('readonly')
    twitter.removeAttribute('readonly')
    instagram.focus()
}

//editar foto de perfil
function editprofileImage(img) {
    //exibir informações
    document.getElementById('postSelectedImageInformation').classList.remove('d-none')

    //esconder botão de deletar imagem
    document.getElementsByClassName('removeImageItem')[0].classList.add('d-none')
    document.getElementsByClassName('removeImageItem')[1].classList.add('d-none')

    //verificar arquivo selecionado
    let msg = document.getElementById('obsImgPreview')

    let lowerImg = img.value.toLowerCase()
    let afterDot = lowerImg.lastIndexOf('.') + 1
    let fileExtension = lowerImg.substr(afterDot)

    if (img.value === "") {
        //esconder as informações de adicionar imagem
        document.getElementById('postSelectedImageInformation').classList.add('d-none')

        //Exibir botão de deletar imagem
        document.getElementsByClassName('removeImageItem')[0].classList.remove('d-none')
        document.getElementsByClassName('removeImageItem')[1].classList.remove('d-none')

    } else if(fileExtension !== 'png' && fileExtension !== 'jpg' && fileExtension !== 'jpeg'){
        //Extensão errada
        img.value = ""
        msg.innerText = "Selecione uma imagem em arquivo .jpg, .jpeg ou .png"
        msg.className = "text-danger"

        document.getElementById('NewProfileImageButtons').classList.add('d-none')
    } else {
        //TUDO CERTO
        msg.innerText = "A imagem mostrada a seguir são apenas prévias (os tamanhos podem estar distorcidos). Os tamanhos originais da imagem são mantidos."
        msg.className = "text-info"

        //limpar imagens caso haja
        document.getElementById('divImgPreview').innerHTML = ""

        //Criando elemento html e settando o src com o filereader
        let reader = new FileReader()

        reader.onload = e => {
            //criando o elemento html
            let tagImg = document.createElement('img')
            tagImg.src = e.target.result
            tagImg.className = 'imgPreview rounded-image'

            //anexando na div designada
            document.getElementById('divImgPreview').appendChild(tagImg)
        }

        //enviando o valor do input file pro reader.onload
        reader.readAsDataURL(img.files[0])

        document.getElementById('NewProfileImageButtons').classList.remove('d-none')
    }
}

function confirmRemoveImage(url){
    if ( confirm("você tem certeza que deseja remover sua foto de perfil?") ){
        location.href = url
    }
}