function reportHandler({node = null, type = '', data = {}} = {}){
/* Esta funcao cuida da parte de criar e lidar com a interface de denuncia, deixando-a pretaparadacom 
os inputs para ser enviados para o backend.
Ela deve ser ustilizada em conjunto com o seu HTML por meio de um iframe.
Ela recebe um 'node', que é o elemento 'body' do html puxado pelo iframe.
Ela retorna  um outro node para ser acoplado a DOM

'type' eh o tipo de denuncia, que precisa estar correlacionado com o 'typeSupported'
'data' eh o obj que contem todos os dados necessarios paa o tipo que foi especificado 

[service] --> ReportInterface({node: iframeNode, type: 'service', data: {service: 'Seriço Nome', provider: "Provedor"}});
[comment] --> ReportInterface({node:iframeNode, type: 'comment', data: { 
        user: 'nome do usuario',
        service: 'nome do servico',
        sequencialNumber: 2,
        publichDate: '2021-06-06 22:55:46',
    }}

[business] --> ReportInterface({node:iframeNode, type: 'business', data: {business: 'businesName'}});
*/

    if(typeof node !== 'object'){console.log(`[ReportHandler] --> type of node is invalid`); return} // caso o tipo do node nao seja nem um obj, ja retona
    
    let typeSupported = { // contem todos os tipos suportados para montar a interface de denuncia. As funcoes de cada um sao mostradados abaixo somente para organizacao
        business: {
            setData: () => {},
            loadInterface : () => {}
        },
        service : {
            setData :() => {},
            loadInterface : () => {}
        },
        comment : {
            setData :() => {},
            loadInterface : () => {}
        },
    };
    if(! (type in typeSupported)) 
        {console.log('[reportHandler] ---> type of report, not supported'); return} // se o type recebido nao eh supportado

    let state = { // obj que armazena todo o estado atual da interface e todas as possiveis variaveis ja estao dedclaradas dentro para organizacao
        type : null,
        service: null,
        provider: null,
        reasonList: [],
        visibleSection : node.querySelector('#myReportSection'),
        comment: null,
        user: null,
        sequencialNumber: null,
        publishDate: null,
        business: null,
    };

    let structureElements = { // comporta alguns elemntos gerais da interface que podem ser acessados mais de uma vez por diferentes functions
        headContainer: node.querySelectorAll('.my-report-header'),
        reasonDropdown: node.querySelector('.my-reason-dropdrown'),
        btnReasonDropdown: node.querySelector('#btnDropdownReport'),
        btnSend: node.querySelector('#btnSend'),
        section: {
            write: node.querySelector('#myReportSection'),
            verify: node.querySelector('#myVerificationSection')
        },
        btnEdit: node.querySelector('.my-edit-report-btn'),
        btnCancel: node.querySelector('.my-cancel-report-btn'),
    }

    typeSupported.business.loadInterface = () => { // carrega a interface de negocios
        structureElements.headContainer.forEach(elem => {
            elem.innerHTML += 
                `<div class="service-report-title">Denunciar o negócio: <label id="myServiceReportName">${state.business}</label></div>`
        });
        
    }

    typeSupported.service.loadInterface = () => { // carrega a intreface de servicos
        structureElements.headContainer.forEach(elem => {
            elem.innerHTML += `
                <div class="service-report-title">Denunciar o serviço: <label id="myServiceReportName">${state.service}</label></div>
                <div class="person-report-title">Prestador: <label id="myPersonReportName">${state.provider}</label></div>`
        })
    }

    typeSupported.comment.loadInterface = () => { // carrega a interface de comentario
        structureElements.headContainer.forEach(elem => {
            elem.innerHTML += `
                <div class="service-report-title">Denunciar o comentário: <br> <label class="dont-break-out" id="myServiceReportName">${data.comment}</label></div>
                <div class="person-report-title">Autor: <label id="myPersonReportName">${data.user}</label></div>
            `})

        dropdownHandler();
    }

    const dropdownHandler = () => { // cuida do dropdown. Preenche o dropdown, cuida de cada item dele que seja selecionando pra atualisar o state e o text do tbn
        structureElements.btnReasonDropdown.innerHTML = state.reasonSelected || "selecione";

        structureElements.reasonDropdown.innerHTML = ""; // limpa o dropdwon
        for(let i in state.reasonList){ // aplica nele toods os itens que estao no array: 'state.reasonList'
            structureElements.reasonDropdown.innerHTML +=
            `<label class="my-report-reason-drop-item dropdown-item">${state.reasonList[i]}</label>`
        }

        let reasonItems = node.querySelectorAll('.my-report-reason-drop-item');
        reasonItems.forEach((item) => { // adicona as functions de click em cada item do dropdown
            item.onclick = () => {
                setState({reasonSelected: item.innerHTML}) // atualiza o state do reasonSelected
            }
        })
    }

    const otherReasonHandler = () => { // caso seja selecionado a opcao 'outro' do dropdow, deve ser mostrado o campo para se digitar o motivo 
        let otherReason = node.querySelectorAll('.other-reason-toggle'); // sao os itens que devem aparecer

        if(state.reasonSelected === "Outro"){ // caso estaja seleciondo a opcao 'Outro'
            otherReason.forEach((elem) => { // toods os itens correspondentes devem ser mostrados
                elem.style.display = "initial";
            });
        }
        else{ // caso nao estja selecionado, esconde
            otherReason.forEach((elem) => {
                elem.style.display = "none";
            });
        }
    }

    const sectionDisplayHandler = () => { // trabalha de verificar quando eh para mstrar a section de verify ou a section de write.
        for(let i in structureElements.section){ // esconde todas
            structureElements.section[i].style.display = 'none'
        }

        state.visibleSection.style.display = 'block'; // deixa visivel aquela que esta no state.

    }

    const refreshAll = () => { // recarrega todas as funcoes que preciam quando o state é atualizado
        otherReasonHandler();
        sectionDisplayHandler();
        dropdownHandler();
    }

    const setState = (props) => { // funcao que atualiza o state. Ela recebe um obj com as propriedade que devam ser atualizadas no state.
        if(typeof props !== 'object') {console.log(`[setState] --> invalid props`); return} // caso não receber um obj, retorne

        for(let i in props){ // percorre as propriedades enviadas para ser atualizada
            if(state[i] !== props[i] ){ // caso ela for diferente, altere
                state[i] = props[i]
            }
        }

        refreshAll(); // atualiza todas as funcoes que dependem 
    }

    typeSupported.business.setData = () => { // insere os dados recebidos no state
        if(typeof data.business !== 'string') {console.log(`[typeSupported.business.setData] --> invalid business name`); return}

        setState({
            type: 'business',
            business: data.business
        })
    }

    typeSupported.service.setData = () => {// insere os dados recebidos no state
        for(let i in data){
            if(typeof data[i] !== 'string') {console.log(`[typeSupported.service.setData] --> invalid service data`); return}
        }
        
        setState({
            type: 'service',
            service: data.service,
            provider: data.provider
        })
    }

    typeSupported.comment.setData = () => { // insere os dados recebidos no state
        setState({
            type: 'comment',
            comment: data.comment,
            user: data.user,
            service: data.service,
            sequencialNumber: data.sequencialNumber,
            publishDate: data.publishDate,
        })
    }

    const setData = () => { // carrega a primeira vez
        typeSupported[type].setData(); // coloca os dados
        typeSupported[type].loadInterface(); // carrega a pagina com iens que nao precisam de state 
    }

    const fiilVerifySection = () => { // cuida de pegar as infos que estoa no stae e colocar na sectionde verify quando ela for acionada pelo btn
        let reasonText = node.querySelector('.my-reason-text-verification');
        let commentText = node.querySelector('.my-comment-verification');

        reasonText.innerHTML = state.reason;
        commentText.innerHTML = state.commentReportText;

        let input_form = { // sao todos os capos de input que deverao ser mandados para o back, nem todos os dados serao preenchidos, pois depende do type da denuncia !! o nome das propriedades devem ter o mesmo nome das mesmas propriedades no state.
            type: node.querySelector('.reportType_form'),
            provider: node.querySelector('.providerName_form'),
            service: node.querySelector('.serviceName_form'),
            business: node.querySelector('.smallBusiness_form'),
            reason: node.querySelector('.reason_form'),
            comment: node.querySelector('.comment_form'),
            user: node.querySelector('.commentUser_form'),
            publishDate: node.querySelector('.commentPublishDate_form'),
            sequencialNumber: node.querySelector('.commentSequncialNumber_form'),
        }

        for(let i in input_form){ // pega os dados do state e coloca nos inputs
            if(state[i]) input_form[i].value = state[i] // se a propriedade que existir no state, existir nesse obj, entao coloca o valor que esta no state no input
        }

    }

    structureElements.btnSend.onclick = () => { // ao clica rno btn enviar que esta na primeira section
        let reason = state.reasonSelected; // pega a coloca a reason selecionada numa variavel 
        if(state.reasonSelected === "Outro"){ // caso ela for 'outro', entao pega o valor que esta digitado no textArea
            let otherReasonText = node.querySelector('.my-other-reason-text').value;
            for(let i = 0; i < otherReasonText.length; i++){ // verifica se so tem campo com espaço dentro do textarea
                if(otherReasonText[i] !== ' ') break;
    
                if(i === otherReasonText.length - 1){
                    otherReasonText = "";
                }
            }
            reason = otherReasonText; // a reason pega o valor que esta no textarea
        }

        let commentReportText = node.querySelector('.my-comment-text').value;

        for(let i = 0; i < commentReportText.length; i++){ // verifica se tem so espaco no campo de comentario 
            if(commentReportText[i] !== ' ') break;

            if(i === commentReportText.length - 1){
                commentReportText = "";
            }

        }


        let errorAlert = node.querySelector('.report-alert-div') // essa eh a div de alert que ele mostra caso estiver erro no preenchimetno de dados 
        if(commentReportText.length === 0 || !reason) // caso algo esteja faltando
            errorAlert.style.display = "block"; // mostrao o alert
        else{
            errorAlert.style.display = "none"; // esconde o alert
            setState({ // muda o stae se tudo estiver certo
                reason,
                commentReportText,
                visibleSection: structureElements.section.verify // muda a section no state
            });

            fiilVerifySection(); // preenche a section 
        }
    }

    structureElements.btnEdit.onclick = () => { // editar as infos 
        setState({visibleSection: structureElements.section.write}) // retorna para a section de editar
    }
    
    structureElements.btnCancel.onclick = () => { // btn cancelar limpa tudo do state 
        setState({
            type : null,
            service: null,
            provider: null,
            reasonList: [],
            visibleSection : node.querySelector('#myReportSection'),
            comment: null,
            user: null,
            sequencialNumber: null,
            publishDate: null,
            business: null,
        });
    }

    setData();

    const getRasons = async () => { // simulacao de tempo de dalay para pegar as informacoes de mostivos de denuncia
        fetch('https://jsonplaceholder.typicode.com/posts')
            .then(reposnse => reposnse.json())
            .then( reposnse => {
                let reasonList = [
                    'reaosn a',
                    'reaosn b',
                    'reao c',
                    'd reason',
                ];

                reasonList.push('Outro') // adiciona o 'outro' no final do array

                setState({reasonList}) // atualiza o state com o seu valor
            })
    }

    getRasons();   
    
    
    return node; // retona o node com tudo resolvido 
}

export default reportHandler;