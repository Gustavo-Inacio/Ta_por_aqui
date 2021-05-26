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
$('#userAdressCEP').mask('00000000');

//confirmar informações no registro (nada nulo, senhas batem, aceitar termos, telefone certo, CEP certo)
let sessionConfirmCode = 0
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
    let userAdressCEP = document.getElementById('userAdressCEP')
    if (userAdressCEP.value.length !== 8){
        valid = false
        errorMsg = "CEP inválido. Siga o padrão do exemplo"

        userAdressCEP.classList.add("is-invalid")
        userAdressCEP.style.border = "1.5px solid red"

    } else{
        userAdressCEP.classList.remove("is-invalid")
        userAdressCEP.style.border = "1.5px solid 888F98"
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
        //requisição do arquivo php que vai gerar o código do usuário e mandar por email
        let email = document.getElementById('userEmail').value
        $.ajax({
            type: 'GET',
            url: '../../logic/cadastro_confirma_email.php',
            data: `email=${email}`,
            dataType: 'json',
            success: sendEmailStatus => {
                if(sendEmailStatus.status === "enviado"){
                    //mostrar modal de confirmação de email
                    $('#confirmEmailModal').modal('show')

                    //desfoque de fundo
                    document.getElementById('page').style.filter = "blur(3px)"

                    //tirar desfoque ao sair do modal
                    $('#confirmEmailModal').on('hidden.bs.modal', () => {
                        document.getElementById('page').style.filter = "none"
                    })

                    //preenchendo email
                    document.getElementById('InputEmailAdress').innerHTML = document.getElementById('userEmail').value

                    //codigo do email
                    sessionConfirmCode = sendEmailStatus.code
                } else {
                    alert("O email de confirmação não pôde ser enviado. Verifique se você digitou um email válido. Se o erro persistir entre em contato pelo 'Fale conosco'")
                }
            },
            error: error => {
                alert("Erro ao se conectar com o servidor. Tente recarregar a página. Se o erro persistir entre em contato pelo 'Fale conosco'")
            }
        })

    }
}

function confirmEmail(){
    let typedCode = document.getElementById('emailCode')

    if(typedCode.value != sessionConfirmCode){
        document.getElementById('confirmEmailError').classList.remove('d-none')
        typedCode.classList.add('is-invalid')
    } else{
        console.log('deu bom')
        document.getElementById('registerForm').submit()
    }
}

//permitir popovers
$(function () {
    $('[data-toggle="popover"]').popover()
})

//Chamando a função getAdress pelo input CEP
function callGetAdress(input){
    if(input.value.length === 8){
        //caso o input tenha 8 digitos ele chama a função passando já o value o cep
        getAdress(input.value)
    }
}

//Selecionando Estado e cidade com a API dos correios
function getAdress(cep){
    let url = `https://viacep.com.br/ws/${cep}/json/unicode/`

    let ajax = new XMLHttpRequest()
    ajax.open('GET', url)

    ajax.onreadystatechange = () => {
		if(ajax.readyState == 4 && ajax.status == 200){
			let enderecoJSON = ajax.responseText

			//convertendo a resposta JSON em objeto
			enderecoJSON = JSON.parse(enderecoJSON)

			if(enderecoJSON.erro == true){
				//tratativa de CEP invalido
				let aviso = document.getElementById('cepError')
				aviso.innerHTML = 'Digite um CEP valido'

			} else{
				//retirando aviso caso exista
				if(document.getElementById('cepError')){
					document.getElementById('cepError').innerHTML = ''
				}

				//Colocando a resposta nos formulários
				document.getElementById('userAdressCity').value = enderecoJSON.localidade
				document.getElementById('userAdressState').value = enderecoJSON.uf
                document.getElementById('userAdressStreet').value = enderecoJSON.logradouro
				document.getElementById('userAdressNeighborhood').value = enderecoJSON.bairro
			}
		}
		if(ajax.readyState == 4 && ajax.status == 400){
			alert('Erro ao se conectar com os correios')
		}

	}

	ajax.send()
}