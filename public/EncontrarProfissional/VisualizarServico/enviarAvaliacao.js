const ajaxTrigger = (data) => // esta funcao rebe os valores e os envia para o Back
{
    let a = "";
    for(let i in data)
    {
        a += data[i] + " , "
    }
    alert(a)
}


const rateDOM = () => {// manipula a interacao com a DOM com a avaliacao do servico
    let section = document.querySelector('#myAvaliationSection'); // esta eh a section que engloba todos os elementos que serao utilizados 

    let stars = section.querySelectorAll('.my-write-rate svg'); // sao os svg de estrelas de pontuacao
    let textArea = section.querySelector('#myWriteComentTextArea'); // o input de comentario
    
    let btnActionDiv = section.querySelector('.write-rate-btn-div'); // eh a div que engloba os btn enviar e cancelar
    let btnAction = {// btn enviar e cancelar
        cancel : section.querySelector('.write-coment-btn-cancel'),
        send : section.querySelector('.write-coment-btn-send')
    }

    let alertDiv = section.querySelector('.rate-stars-error-div'); // div de alert de erro ou falta de dados

    let state = { // aqui estao todos os dados 
        rateNumber: 0, // esta eh a nota de aviacao
        comment: '', // comentario
        textAreafocus : false // caso o o input de comentario foi selecionado (a btnActionDiv sera mostrada)
    }

    const paintStars = () => { // pinta as estrelinhas selecionadas, o valor esta no state.
        for(let i =0 ;i < stars.length; i++){ // descolore todas
            stars[i].querySelector('path').setAttribute('fill', "none");
        }

        for(let i = 0; i < state.rateNumber && i < stars.length; i++){ // pinta de acordo com o numero contido no state 
            stars[i].querySelector('path').setAttribute('fill', "#FF9839");
        }
    }

    const showBtnAction = () => { // cuida de mostrar ou esconder a div de btn de acao
        if(state.textAreafocus) // caso o input de comatario foi selecionado
            btnActionDiv.style.display = 'flex';
        else
            btnActionDiv.style.display = 'none';
    }

    const togglebtnSendColor = () => { // cuida de deixar o btn send ativo ou sesativado
        if(state.comment === ""){ // caso nao tenha comentario nenhum.
            btnAction.send.disabled = true
        }
        else{
            btnAction.send.disabled = false
        }
    }

    const textAreaHandler = () => { // cuida de preencher o textarea com o valor do state
        textArea.value = state.comment;
        togglebtnSendColor(); // atualiza a cor do btn
    }

    const refreshAll = (obj) => { // quando atualiza o state, ela deve atualizar tudo que depende da propriedade que foi atualizada
        if('rateNumber' in obj) // caso atulizaou o valor de avaliacao
            paintStars(); // refaz as estrelinhas
        if('comment' in obj) // caso mudou o comentario
            textAreaHandler(); // atualiza o que depende do comentario
        if('textAreafocus' in obj) // caso focalizou no input 
            showBtnAction(); // atualiza o que depende desse estado 
    }

    const setState = (obj = null) => { // funcao que serve para atualizar o state. Deve ser enviado um obj para ela com a propriedade e o valor que se deseja inserir nela 
        if(!obj) return;
        
        for(let i in obj){
            if(state[i] !== obj[i]){ // caso a propriedade enviada for diferente da que ja existe
                state[i] = obj[i]; // atualiza o state 
                refreshAll(obj) // atualiza a interface com base no state atualizado 
            }
        }
    }

    stars.forEach((star, index) => { // acad estrelinha devera ter uma funcao onclick para atualizar o state com o valor da avaliacao
        star.onclick = () => {
            setState({rateNumber : index + 1});
        }
    });

    const clearFields = () => { // limpa todo o state.
        setState({comment: '', rateNumber: 0, textAreafocus: false})
    }

    btnAction.cancel.onclick = () => {
        clearFields();
    }

    btnAction.send.onclick = () => {
        if(state.rateNumber > 0  && state.comment !== ""){ // caso os valores forem validos 
            ajaxTrigger(state); // manda para a funcao de ajax 
            clearFields(); // limpa os campos 
            alertDiv.style.display = 'none'; // retira o alert de erro
        }
        else{
            alertDiv.style.display = 'block'; // coloca o alert de erro
        }

        
    }

    if(textArea.addEventListener){ // caso seja suportado o eventListener 
        textArea.addEventListener('input',(value) => { // caso o usuario digite algo
            setState({comment: textArea.value});
        })

        textArea.addEventListener('focus', () => { // caso o susario facalize o input
            setState({textAreafocus: true});
        })

      /*  stars.forEach((star, index) => {
            star.addEventListener('mousemove', () => {
                setState({rateNumber : index + 1});
            })

            star.onclick = () => {
               
            }
        });*/
    }
    else if (textArea.attachEvent) { // para IE
        area.attachEvent('onpropertychange', () => {
            setState({comment: textArea.value});
        });
    }

}

rateDOM();