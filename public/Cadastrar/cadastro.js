//Exibindo / escondendo senha
let aux = 0
function showPass(){
    let loginPass = document.getElementById('userPass')
    let eye = document.getElementById('eye')

    if(aux%2 == 0){
        //mostrar senha
        loginPass.type = "text"
        eye.className = "fas fa-eye-slash"
    } else{
        //esconder senha
        loginPass.type = "password"
        eye.className = "fas fa-eye"
    }
    
    aux++
}

let aux2 = 0
function showConfirmPass(){
    let loginPass = document.getElementById('userConfirmPass')
    let eye = document.getElementById('eye2')

    if(aux%2 == 0){
        //mostrar senha
        loginPass.type = "text"
        eye.className = "fas fa-eye-slash"
    } else{
        //esconder senha
        loginPass.type = "password"
        eye.className = "fas fa-eye"
    }
    
    aux++
}

//mascara do telefone
$('#userPhone').mask('(00) 00000-0000');

//mascara do cep
$('#userCEP').mask('00000000');

//confirmar informações no registro (nada nulo, senhas batem, aceitar termos, telefone certo, CEP certo)
function registerConfirm(){
    let valid = true
    let errorMsg = ""

    //confirmar senha igual
    let userPass = document.getElementById('userPass')
    let userConfirmPass = document.getElementById('userConfirmPass')
    if (userPass.value !== userConfirmPass.value){
        valid = false
        errorMsg = "As senhas não batem"

        userPass.classList.add("is-invalid")
        userPass.style.border = "1.5px solid red"

        userConfirmPass.classList.add("is-invalid")
        userConfirmPass.style.border = "1.5px solid red"

    } else{
        userPass.classList.remove("is-invalid")
        userPass.style.border = "1.5px solid 888F98"

        userConfirmPass.classList.remove("is-invalid")
        userConfirmPass.style.border = "1.5px solid 888F98"
    }

    //telefone tem 15 caracteres
    let userPhone = document.getElementById('userPhone')
    if (userPhone.value.length !== 15){
        valid = false
        errorMsg = "Número de telefone inválido. Siga o padrão do exemplo"

        userPhone.classList.add("is-invalid")
        userPhone.style.border = "1.5px solid red"

    } else{
        userPhone.classList.remove("is-invalid")
        userPhone.style.border = "1.5px solid 888F98"
    }

    //CEP tem 8 caracteres
    let userCEP = document.getElementById('userCEP')
    if (userCEP.value.length !== 8){
        valid = false
        errorMsg = "CEP inválido. Siga o padrão do exemplo"

        userCEP.classList.add("is-invalid")
        userCEP.style.border = "1.5px solid red"

    } else{
        userCEP.classList.remove("is-invalid")
        userCEP.style.border = "1.5px solid 888F98"
    }

    //Aceitar os termos de uso
    let termsOfUse = document.getElementById('termsOfUse')
    if(termsOfUse.checked == false){
        valid = false
        errorMsg = "Aceite os termos de uso"
    }

    //nada nulo
    let inputs = []
    inputs = document.getElementsByClassName('required')
    $(inputs).each((index, input)=>{
        if(input.value == ""){
            valid = false
            errorMsg = "Preencha todos os campos"

            input.classList.add("is-invalid")
            input.style.border = "1.5px solid red"

        } else{
            input.style.border = "1.5px solid #888F98"
            input.classList.remove("is-invalid")
        }
    })

    document.getElementById('msgErro').innerHTML = errorMsg
    
    if(valid){
        document.getElementById('registerForm').submit()
    }
}