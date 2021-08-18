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
    let site = document.getElementById("userSite")
    let description = document.getElementById("userDescription")

    name.removeAttribute('readonly')
    name.style.color = 'black'
    name.focus()

    lastName.removeAttribute('readonly')
    lastName.style.color = 'black'

    cell.removeAttribute('readonly')
    cell.style.color = 'black'

    site.removeAttribute('readonly')
    site.style.color = 'black'

    description.removeAttribute('readonly')
    description.style.color = 'black'

    //aplicando mascara jQuey no input celular
    $(cell).mask('(00) 00000-0000');
}

//editar o nome das redes sociais
function editaRedes(){
    //escondendo links
    $('.mediaLink').each( (index, link) => {
        link.classList.add('d-none')
    } )

    //exibindo os inputs de edição
    $('.socialInput').each( (index, input) => {
        input.classList.remove('d-none')
    } )

     //exibindo dica
    document.getElementById("obsRedeSocias").classList.remove('d-none')

    //mostrando botões
    document.getElementById('socialMediaEdit').className = 'd-none'
    document.getElementById('btnSalvarRedes').classList.remove('d-none')
    document.getElementById('btnCancelarRedes').classList.remove('d-none')


}

function verifySocialMedia() {
    let msgErro = ""
    let valido = true
    //Verificação dos campos do instagram
    if( document.getElementsByClassName('instagram')[0].value !== "" || document.getElementsByClassName('instagram')[1].value !== "" ){
        //verifica se é uma url válida
        if( document.getElementsByClassName('instagram')[1].value.indexOf("https://www.instagram.com/") === -1 ){
            valido = false
            msgErro = "Digite um link como: 'https://www.instagram.com/seu_nome' no campo do instagram"
        }

        //verifica se ambos campos do instagram estão digitados caso 1 esteja digitado
        $('.instagram').each( (index, input) => {
            if(input.value === ""){
                valido = false
                msgErro = "Preencha os dois campos da rede social, ou deixe ambos em branco."
            }
        } )
    }

    //Verificação dos campos do facebook
    if( document.getElementsByClassName('facebook')[0].value !== "" || document.getElementsByClassName('facebook')[1].value !== "" ){
        //verifica se é uma url válida
        if( document.getElementsByClassName('facebook')[1].value.indexOf("https://www.facebook.com/") === -1 ){
            valido = false
            msgErro = "Digite um link como: 'https://www.facebook.com/seunome' no campo do facebook"
        }

        //verifica se ambos campos do facebook estão digitados caso 1 esteja digitado
        $('.facebook').each( (index, input) => {
            if(input.value === ""){
                valido = false
                msgErro = "Preencha os dois campos da rede social, ou deixe ambos em branco."
            }
        } )
    }

    //Verificação dos campos do twitter
    if( document.getElementsByClassName('twitter')[0].value !== "" || document.getElementsByClassName('twitter')[1].value !== "" ){
        //verifica se é uma url válida
        if( document.getElementsByClassName('twitter')[1].value.indexOf("https://twitter.com/") === -1 ){
            valido = false
            msgErro = "Digite um link como: 'https://twitter.com/seu_nome' no campo do twitter"
        }

        //verifica se ambos campos do twitter estão digitados caso 1 esteja digitado
        $('.twitter').each( (index, input) => {
            if(input.value === ""){
                valido = false
                msgErro = "Preencha os dois campos da rede social, ou deixe ambos em branco."
            }
        } )
    }

    //Verificação dos campos do linkedin
    if( document.getElementsByClassName('linkedin')[0].value !== "" || document.getElementsByClassName('linkedin')[1].value !== "" ){
        //verifica se é uma url válida
        if( document.getElementsByClassName('linkedin')[1].value.indexOf("https://br.linkedin.com/in/") === -1 ){
            valido = false
            msgErro = "Digite um link como: 'https://br.linkedin.com/in/seu-perfil' no campo do linkedin"
        }

        //verifica se ambos campos do linkedin estão digitados caso 1 esteja digitado
        $('.linkedin').each( (index, input) => {
            if(input.value === ""){
                valido = false
                msgErro = "Preencha os dois campos da rede social, ou deixe ambos em branco."
            }
        } )
    }

    if(valido){
        //document.getElementById('socialMediaForm').submit()
        document.getElementById('socialMediaForm').submit()
    } else {
        document.getElementById('socialMediaMsgError').classList.remove('d-none')
        document.getElementById('socialMediaMsgError').classList.add('d-block')
        document.getElementById('socialMediaMsgError').innerText = msgErro
    }
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
        msg.innerText = "A imagem a seguir é uma prévia de como será mostrada sua foto de perfil."
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

function acceptRejectService(choice, contract, client) {
    //esmanescendo o modal inferior (de mostrar todos os serviços)
    $('#confirmAcceptRejectModal').on('show.bs.modal', e => {
        e.target.style.backgroundColor = "rgba(0,0,0,0.4)"
    })

    //personalizando modal de confirmação de escolha
    if(choice === 'accept'){
        document.getElementById('confirmModalChoice').className = "text-success"
        document.getElementById('confirmModalChoice').innerText = "aceitar"

        document.getElementById('confirmModalMessage').className = "text-success"
        document.getElementById('confirmModalMessage').innerText = "Ao aceitar prestar esse serviço, seu cliente poderá comentar e avaliar publicamente seu serviço prestado"

        document.getElementById('confirmModalConfirmChoice').className = 'btn btn-success'
        document.getElementById('confirmModalConfirmChoice').innerText = 'Aceitar'
    } else {
        document.getElementById('confirmModalChoice').className = "text-danger"
        document.getElementById('confirmModalChoice').innerText = "rejeitar"

        document.getElementById('confirmModalMessage').className = "text-danger"
        document.getElementById('confirmModalMessage').innerHTML = "Ao rejeitar prestar esse serviço, o usuário que pediu receberá uma notificação de que o serviço solicitado foi rejeitado e ele não poderá avaliar e comentar no seu serviço. <br> Todavia o usuário poderá requisitar seu serviço denovo mais tarde."

        document.getElementById('confirmModalConfirmChoice').className = 'btn btn-danger'
        document.getElementById('confirmModalConfirmChoice').innerText = 'Rejeitar'
    }
    document.getElementById('confirmModalConfirmChoice').href = `../../logic/perfil_aceitar_servico.php?escolha=${choice}&contrato=${contract}`
    document.getElementById('confirmModalUserName').innerText = client

    $('#confirmAcceptRejectModal').modal('show')
}