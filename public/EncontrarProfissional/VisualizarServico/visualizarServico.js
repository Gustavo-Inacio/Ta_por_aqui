import ReportInterface from '../../Denuncia/denuncia.js';

const serviceImgIndicatorsHandler = () => { // cuida dos indicators do carrousel
    let indicator = document.querySelectorAll(".my-carousel-indicator-item ");
    let carouselImg = document.querySelectorAll(".carousel-item");

    let state = {
        imgNumber : 0 // indica qual a imagem aselecondada
    }

    setInterval(() => { // fica verificando qual o carousel-item que esta ativo
        for(let i = 0; i < carouselImg.length; i++){ // passa por todos os carousel-item

            if(carouselImg[i].classList.contains('active')) {
                state.imgNumber = i; // pega o valor do que esta ativo e atualiza no state
            }

            indicator[i].classList.remove('active'); // retira o active de todos os carousel-item
        }
        indicator[state.imgNumber].classList.add('active'); // deixa ativo somente o que foi detectado
    }, 100);

    indicator.forEach((img, index) => { // todos os indicators possuem essa funcao
        img.onclick = () => {
            state.imgNumber = index; // modifica o state para o novo valor

            for(let i = 0; i < carouselImg.length; i++){
                carouselImg[i].classList.remove('active'); // retira o active de todos os itens
            }

            carouselImg[state.imgNumber].classList.add('active'); // coloca active somente o que esta no state.
        }
    });

    carouselImg.forEach((indicator) => { // cuida do click sobre a igm do carrousel
        let realImg = indicator.querySelector('img');
        let displayArea = document.querySelector('.carousel-img-display');
        let backdrop = document.querySelector('.caousel-img-display--backdrop');

        realImg.onclick = () => {
            let img = document.importNode(realImg, true) // pega o elemento imagem de dentro da dom
    
            displayArea.classList.add('show'); // mostra a area
            backdrop.classList.add('show'); // mostra a backdrop
            displayArea.innerHTML = ""; // limpa a area
            displayArea.append(img); // insere a img
        }

        backdrop.onclick = () => { // ao clicar na backdrop toa a area some
            displayArea.classList.remove('show');
            backdrop.classList.remove('show');
        }
    });

};

const providerRateStars = () => {
    /*let rate_e = document.querySelector('.provider-rate--number');
    let rate = rate_e.innerHTML * 1;
    rate_e.innerHTML = rate.toFixed(2);

    let stars = document.querySelectorAll('.provider-rate-div .provider-rate--stars path');
    stars.forEach((star) => {
        star.setAttribute("fill", "#AAAAAA");
    });

    for(let i = 0; i< Math.round(rate) && i < stars.length; i++){
        stars[i].setAttribute("fill", "#FF9839");
    }*/
}
providerRateStars();

const descriptionHandler = () => {
    const btnToggler = document.getElementById("myDescriptionToggleLabel");
    let description_e = document.getElementById("myDescriptionText");
    const txtDescription = description_e.innerText;

    let maxCaracter = 200; // numero maximo de caracteres por fatia do texto
    maxCaracter = window.innerHeight * 0.5;
    let btnStatus = 0; // e o campo do array que sera mostrado

    let splitText = []; // este array comporta em cada campo uma fatia do texto determinada pelo maxCaracter
    let splitQuantity = Math.floor(txtDescription.length / maxCaracter);
    if(splitQuantity === 0) splitQuantity = 1; 
    for(let i = 0; i < splitQuantity; i++){
        let textInitial = (i) * splitQuantity;
        splitText[i] = txtDescription.slice(textInitial, textInitial + maxCaracter + 1);
    }

    description_e.innerText = splitText[0]; // esta e a primeira a ser rodada, com o maxCaracter

    if(splitText.length === 1) btnToggler.style.display = 'none'; // caso a descricao nao necessite do 'Ler mais'

    btnToggler.onclick = () => {
        if(btnStatus == splitText.length - 1){ // se a ultima fatia ja estiver sendo mostrada
            btnStatus = 0; // determina a primeira fatia
            description_e.innerText = splitText[btnStatus]; // retorne a primeira fatia
            btnToggler.innerText = "Ler mais";
        }
        else{
            btnStatus++;
            description_e.innerText += splitText[btnStatus]; // adiciona a proxima fatia 
            
            if(btnStatus == splitText.length - 1){ // caso essa seja a ultima fatia
                btnToggler.innerText = "Ocultar";
            }
        }
    }
}

const writeCommentResizeTextArea = () => { // esta funcao evita que o textarea tenha scroll, pois aumenta seu tamenho de acodo com o texto
    let textarea_e = document.getElementById("myWriteComentTextArea");

    textarea_e.onkeydown = () => {
        textarea_e.style.height = '1px';
        textarea_e.style.minHeight = '1px';
        textarea_e.style.maxHeight = '1px';

        textarea_e.style.minHeight = (textarea_e.scrollHeight) + "px";
        textarea_e.style.maxHeight = (25 + textarea_e.scrollHeight) + "px";
        textarea_e.style.height = ( textarea_e.scrollHeight) + "px";
    }
}

const dotOptionsHandler = () => {
    let toggler = document.getElementsByClassName("service-3dot");
    for(let i = 0; i < toggler.length; i++){
        toggler[i].onclick = () => [
            document.getElementById("serviceMenuOptions").classList.toggle("show")
        ]
    }
} 
 
const loadReportService = () => { // carrega e monat o layout de dununcia.
    let iframeNode;
    
    const setDOM = () => { // coloca na DOM
        let serviceName = document.getElementById("myServiceName").innerHTML;
        let providerName = document.getElementById("myProviderName").innerHTML;
        let serviceId = document.getElementById('getServiceIdForComplain').value
        let processedNode = ReportInterface({node:iframeNode, type: 'service', data: {service: serviceName, provider: providerName, serviceId: serviceId}});
    
        let modal = document.querySelector('#serviceReportModal #myReportModalBody');
        modal.appendChild(processedNode)

        let submitform = processedNode.querySelector('#complainForm')
        submitform.addEventListener('submit', event => {
            event.preventDefault()

            let formData = new FormData(event.target)
            let xhr = new XMLHttpRequest()

            let msg = processedNode.querySelector('#my-report-verification-section-subtitle')
            let btn = processedNode.querySelector('#submitComplain')

            xhr.open('POST', '../../../logic/denuncia_enviar.php')
            btn.innerHTML = 'Enviar Denúncia <div class="spinner-border" role="status" style="width: 16px; height: 16px"></div>'

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4){
                    if (xhr.status == 200){
                        let response = JSON.parse(xhr.response)
                        if (response[0] === '00000'){
                            //exibir mensagem de sucesso
                            msg.className = 'text-success fw-bold'
                            msg.innerHTML = "Denúncia enviada com sucesso. Obrigado por ajudar a plataforma a melhorar!"
                            msg.style.fontSize = "18px"
                        } else if(response[0] === 'not logged'){
                            msg.className = 'text-danger fw-bold'
                            msg.style.fontSize = "18px"
                            msg.innerHTML = "Erro ao acessar seu login. Verifique se você realmente está logado e tente novamente. Caso o erro persistam entre em contato pelo fale conosco"
                        } else {
                            msg.className = 'text-danger fw-bold'
                            msg.style.fontSize = "18px"
                            msg.innerHTML = "Erro ao processar denúncia. Recarregue a página e tente novamente. Caso o erro persista, entre em contato pelo fale conosco."
                        }
                    } else {
                        msg.className = 'text-danger fw-bold'
                        msg.style.fontSize = "18px"
                        msg.innerHTML = "Erro ao enviar denúncia para o servidor. Recarregue a página e tente novamente. Caso o erro persista, entre em contato pelo fale conosco."
                    }

                    //substituir botão de enviar por botão de fechar
                    btn.innerHTML = 'Fechar'
                    btn.className = 'mybtn mybtn-secondary'
                    btn.type = 'button'
                    btn.setAttribute('data-bs-dismiss', 'modal')

                    //Excluir botão de editar
                    processedNode.querySelector('.my-edit-report-btn').remove()

                    //excluir seção de confirmação
                    processedNode.querySelector('#data-confirm').remove()
                }
            }
            xhr.send(formData)
        })
    }

    const getNode = async () => { // faz a requisicao pelo NODE
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../Denuncia/denuncia.php');
        xhr.onload = async () => {
            let tempDiv_e = document.createElement('div'); 
            tempDiv_e.innerHTML = await xhr.response; // coloca o código recebido numa div pq ele vem em string 
            iframeNode =  document.importNode(tempDiv_e, true); // depois import o node de dentro da div
            setDOM();  // monta a dom
        }
        xhr.send();
    }
    getNode();
}

const commentSectionHandler = (info = []) => { // cuida da section inteira de comentarios
    if(info === []) return;

    let template_e = document.getElementById('myCommentTemplate'); // emplate do modelo de comentario
    let section_e = document.getElementById('myComentSection');
    let sectionContainer = document.querySelector('.my-coment-section-container'); // eh o container da section, onde serao inseridos os comntarios
    let profileImgSrc = "";

    let elements = { // todos os elemntos que serao maipulados da DOM
        userName: template_e.content.querySelector('.my-coment-user-name'),
        profilePicture: new Image(),
        rateStars : template_e.content.querySelector('.my-rate-stars'),
        publishDate: template_e.content.querySelector('.my-coment-publish-date'),
        text: template_e.content.querySelector('.my-coment-text'),
    }

    const commentItem = (data = {}) => { // cuida de cada comentario

        const addFunctions = (item = null) => { // As funcoes que cada comentario devera ter. Ela deve receber o elemnto comentario antes de ser inserido na DOM.
            if(typeof item !== 'object') return; // o elemento DOM tem typeof 'object'

            const moreOpstionHandler = () => { // soa os tres pontinhos na lateral esquera
                let btnMoreOption = item.querySelector('.my-coment-tecnical-option-3-dot')
                let optionMenu = item.querySelector('#serviceMenuOptions');

                btnMoreOption.onclick = () => { // quando ele for clicado, toggle o menu
                    if (optionMenu.style.display === 'initial')
                        optionMenu.style.display = 'none';
                    else
                        optionMenu.style.display = 'initial';
                }
            }

            const readMoreHandler = () => { // cuida odo texto do comentario
                let btnReadMore = item.querySelector('.my-coment-read-more'); // btn ler mais
                const maxCaracter = 300; // numero maximo de caracteres a serem mostrados por padrao
                let splitText = []; // ['texto a ser exibido por padrao', 'restante do texto]

                let textComment_e = item.querySelector('.my-coment-text'); // eh o elemento de texto
                let textComment = textComment_e.innerHTML; // texto do elemnto de texto
                
                splitText[0] = textComment.slice(0, maxCaracter); // separa o texto padaro
                splitText[1] = textComment.slice(maxCaracter, textComment.length); // separa o texto que sera acionado

                textComment_e.innerHTML = splitText[0]; // coloca o padrao diretamente na primeira vez

                if(textComment.length <= maxCaracter) btnReadMore.style.display = "none"; // caso o comentario nao necessite do 'Ler mais'

                btnReadMore.onclick = () => { // caso seja clicado o 'ler mais'
                    if(textComment_e.innerHTML === splitText[0] + splitText[1]){ // caso ja exista as duas partes na tela
                        textComment_e.innerHTML = ""; // limpa o texto
                        textComment_e.innerHTML = splitText[0]; // coloca somente o padrao
                        btnReadMore.innerHTML = "Ler Mais"; // muda o texto do btn ler mais
                    }
                    else{ // caso estiver somente a primeira parte do texto
                        textComment_e.innerHTML = splitText[0] + splitText[1]; // coloca as duas partes
                        btnReadMore.innerHTML = "Ocultar"; // muda o texto do btn 
                    }
                    
                }
            }

            const publishDateHandler = () => { // manipula o formato da data de publicacao. o formato esperado de entrada é o do NOW() do mySQL --> 2021-06-30 22:55:46
                let publish_e = item.querySelector('.my-coment-publish-date');
                let [date, time] = publish_e.innerHTML.split(" ") // separa a data da hora

                let [year, month, day] = date.split('-'); // separa os valores da data

                publish_e.innerHTML = `${day}/${month}/${year}` // coloca na DOM
            }


            let commentId = data.commentId;
            let user = data.userName;
            let publishDate = data.publishDate;
            let service = document.getElementById("myServiceName").innerHTML;
            let sequencialNumber = sectionContainer.querySelectorAll('.my-coment-row').length;
            let comment = data.text;
            let modal = item.querySelector('#reportComent');
            let modalBody = item.querySelector('#myReportModalBody')

            let modalTrigger = item.querySelector('#reportCommentID')
            const reportHandler = async () => { // envia os valores para a fcnao que gera e retorna o elemtno de denuncia para adicionar no modal
                let iframeNode;
                const getNode = async () => { // busca o node por ajax
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', '../../Denuncia/denuncia.php');
                    xhr.onload = async () => {
                        let tempDiv_e = document.createElement('div');
                        tempDiv_e.innerHTML = await xhr.response;
                        iframeNode =  document.importNode(tempDiv_e, true);

                        setDOM();
                    }
                
                    xhr.send();
                }
                
                getNode();
                const setDOM = async () => { // monta o layout na DOM
                    let processedNode = await ReportInterface({node:iframeNode, type: 'comment', data: {comment: comment, user, publishDate, service, sequencialNumber, commentId: commentId}})
                   
                    await modalTrigger.setAttribute('data-bs-target',`#reportComent${sequencialNumber}`) // muda o id para nao dar conflito entre os modais de comentario
                    await modal.setAttribute('id',`reportComent${sequencialNumber}`)// muda o id para nao dar conflito entre os modais de comentario
    
                    await modalBody.appendChild(processedNode) // pega o node retornado e o coloca na DOM

                    let submitform = processedNode.querySelector('#complainForm')
                    submitform.addEventListener('submit', event => {
                        event.preventDefault()

                        let formData = new FormData(event.target)
                        let xhr = new XMLHttpRequest()

                        let msg = processedNode.querySelector('#my-report-verification-section-subtitle')
                        let btn = processedNode.querySelector('#submitComplain')

                        xhr.open('POST', '../../../logic/denuncia_enviar.php')
                        btn.innerHTML = 'Enviar Denúncia <div class="spinner-border" role="status" style="width: 16px; height: 16px"></div>'

                        xhr.onreadystatechange = () => {
                            if (xhr.readyState == 4){
                                if (xhr.status == 200){
                                    let response = JSON.parse(xhr.response)
                                    if (response[0] === '00000'){
                                        //exibir mensagem de sucesso
                                        msg.className = 'text-success fw-bold'
                                        msg.innerHTML = "Denúncia enviada com sucesso. Obrigado por ajudar a plataforma a melhorar!"
                                        msg.style.fontSize = "18px"
                                    } else if(response[0] === 'not logged'){
                                        msg.className = 'text-danger fw-bold'
                                        msg.style.fontSize = "18px"
                                        msg.innerHTML = "Erro ao acessar seu login. Verifique se você realmente está logado e tente novamente. Caso o erro persistam entre em contato pelo fale conosco"
                                    } else {
                                        msg.className = 'text-danger fw-bold'
                                        msg.style.fontSize = "18px"
                                        msg.innerHTML = "Erro ao processar denúncia. Recarregue a página e tente novamente. Caso o erro persista, entre em contato pelo fale conosco."
                                    }
                                } else {
                                    msg.className = 'text-danger fw-bold'
                                    msg.style.fontSize = "18px"
                                    msg.innerHTML = "Erro ao enviar denúncia para o servidor. Recarregue a página e tente novamente. Caso o erro persista, entre em contato pelo fale conosco."
                                }

                                //substituir botão de enviar por botão de fechar
                                btn.innerHTML = 'Fechar'
                                btn.className = 'mybtn mybtn-secondary'
                                btn.type = 'button'
                                btn.setAttribute('data-bs-dismiss', 'modal')

                                //Excluir botão de editar
                                processedNode.querySelector('.my-edit-report-btn').remove()

                                //excluir seção de confirmação
                                processedNode.querySelector('#data-confirm').remove()
                            }
                        }
                        xhr.send(formData)
                    })
                }
            }
            moreOpstionHandler();
            readMoreHandler();
            publishDateHandler();
            reportHandler();
        }

        const rateHandler = (rateNumber) => { // cuida de pintar as estrelinhas de acordo com a avaliacao
            let paths = elements.rateStars.querySelectorAll('path'); // estes soa os paths dos svg que deverao ser coloridos

            for(let i = 0; i < paths.length; i++){ // descolore todos eles
                paths[i].setAttribute('fill', '#AAAAAA')
            }
            for(let i = 0; i < rateNumber && i < paths.length; i++){ // pinta ate o numero especificado 
                paths[i].setAttribute('fill', "#FF9839")
            }
        }

        const loadProfileImgHandler = (item = null) => { // trata de carregar a imagem, pois ela demora amis do que o resto. Deve ser passado o elemento comentario
            if(!typeof item === 'object') return; 

            let profilePicture_div = item.querySelector(".my-coment-profile-picture-div"); // esta é a div pai da imagem
            let picture = new Image(); // cria-se uma nova imagem

            picture.onload = () => { // quando essa imagem finalizar o seu carregamento, ela é mostrada 
                picture.setAttribute('class', 'my-coment-profile-picture'); // coloca as calsses de css
                picture.setAttribute('alt', 'Foto de Perfil'); // colocaum alt
                
                profilePicture_div.appendChild(picture); // aplica na DOM
                profilePicture_div.classList.remove('loading'); // remove o efeito de loading do elemnto pai.
            }

            picture.src = profileImgSrc;
            
        }

        for(let i in elements){ // percorre todos os elemntos a serem preenchidos
            if(! data[i]) { // se ele não existir 
                // console.groupCollapsed("faltam informacoes para preencher o comentario")
                //     console.log('array total --> ', info)
                //     console.log('elemento --> ', info)
                //     console.log('index --> ', i)
                // console.groupEnd();
                return;
            }

            if(i === 'profilePicture'){ // se for a a imagem
                profileImgSrc = data[i];
            }
            else if(i === 'rateStars') // se for a nota de avaliacao
                rateHandler(data[i]);
            else
                elements[i].innerHTML = data[i]

        }

        let newItem = document.importNode(template_e.content, true) // importa o node de dentro do template
        addFunctions(newItem); // adiciona as funcoes no elemnto
        loadProfileImgHandler(newItem) // inicia o carregamento da imagem

        sectionContainer.appendChild(newItem); // coloca na DOM
    }
    
    info.forEach((data) => { // para cada item recebido, chama a funcao que cria cada um e manda criar 
        commentItem(data)
    });
    
}

const initializeOtherServiceSlider =(data = []) => { // cuida da listagem de outros servicos
    if(data === []){
        return;
    }

    let section = document.getElementById('myOtherServicesSection');
    
    let otherServicesSlider = new Glider(document.querySelector('.glider'), { // criaca do slider usando o glider
        slidesToScroll: 1,
        slidesToShow: 1,
        draggable: true,
        dots: '.dots',
        arrows: {
            prev: '.glider-prev',
            next: '.glider-next'
        },
        responsive : [
            {
                breakpoint : 350,
                settings :{
                    slidesToScroll: 1,
                    slidesToShow: 1.2,
                }
            }, 
            {
                breakpoint : 470,
                settings :{
                    slidesToScroll: 1,
                    slidesToShow: 1.3,
                }
            }, 
            {
                breakpoint : 540,
                settings :{
                    slidesToScroll: 1,
                    slidesToShow: 1.5,
                }
            }, 

            {
                breakpoint : 576,
                settings :{
                    slidesToScroll: 1,
                    slidesToShow: 1.6,
                }
            }, 
            {
                breakpoint : 630,
                settings :{
                    slidesToScroll: 1,
                    slidesToShow: 1.7,
                }
            },
            {
                breakpoint : 690,
                settings :{
                    slidesToScroll: 1,
                    slidesToShow: 1.9,
                }
            },
            {
                breakpoint : 820,
                settings :{
                    slidesToScroll: 2,
                    slidesToShow: 2.3,
                }
            },

            {
                breakpoint : 890,
                settings :{
                    slidesToScroll: 2,
                    slidesToShow: 2.5,
                }
            },

            {
                breakpoint : 890,
                settings :{
                    slidesToScroll: 2,
                    slidesToShow: 2.7,
                }
            },
            {
                breakpoint : 1020,
                settings :{
                    slidesToScroll: 2.3,
                    slidesToShow: 2.85,
                }
            },
            {
                breakpoint : 1200,
                settings :{
                    slidesToScroll: 2.9,
                    slidesToShow: 3.4,
                }
            }
        ]
    });

    const otherServiceItem = async(info = {}) => { // cuida do preenchimento e aplicacao na DOM de cada servico
        return new Promise ((resolve, reject) => {
            let template_e = document.importNode(document.getElementById('myOtherServiceTemplate').content, true); // este e o template do item

            let elements = { // contem os elmentos do temlate
                link: template_e.querySelector('.my-other-service-link'),
                providerName: template_e.querySelector('.my-other-service-card--provider-name'),
                serviceName: template_e.querySelector('.my-other-service-card--service-name'),
                providerPicture: document.createElement('img'), // o elemnto img eh criado pelo js porque deve-se esperar a img carregar para mostrar o item
                serviceRateNumber: template_e.querySelector('.my-rate-service-number > label'),
                serviceLoaction: template_e.querySelector('.my-other-service-location'),
                servicePrice: template_e.querySelector('.my-other-service-price'),
            }

            elements.providerPicture.onload = () => { // quando a imagem do prestador carregar tudo
                try{ // junta tudo e poe na DOM

                    elements.providerPicture.classList.add('my-other-service--person-picture'); // adiciona as classes ao elemento img criado pelo js.
                    elements.providerPicture.setAttribute('alt', 'Foto de perfil') // adiciona um alt no img criaod pelo js 
    
                    let photoContainer = template_e.querySelector('.my-other-service--person-picture-div'); // esta eh a div onde sera colocada o le,ento img criado pelo js 
                    photoContainer.innerHTML = ""; // limpar ela antes de usar, pois as imagens de itens anteriores ficam aqui ainda.
                    photoContainer.appendChild(elements.providerPicture); // coloca o img criado pelo js 
    
                    let newItem = template_e; // cria-se um node com as devidas informacoes
    
                    section.style.display = "initial"; // faz a section aparecer caso for colocar um item, pois ela fica escondida por padrao
                    otherServicesSlider.addItem(newItem); // insere o node na lista - pelo metodo do glider.js

                    

                    resolve(true); // se chegou aqui, é que deu tudo certo!
                } 
                catch (error)
                {
                    reject(`nao foi possivel completar a acao, error ---> ${error}`); //deu errado, que pena.
                }
            }

            for(let i in elements){ // percorre todos os elemtnos que deverao ser preenchidos
                // if(!info[i]) { // caso nao tenha sido enviada a inforamacao para ser preenchido o cartao. O modelo do objeto a ser recebido eh o mesmo de {elements}
                //     console.groupCollapsed("faltam informacoes para preencher o cartao de outros servicos")
                //         console.log('array total --> ', info)
                //         console.log('elemento --> ', info)
                //         console.log('index --> ', i)
                //     console.groupEnd();
                //     // return;
                // };

                if(i === 'link') // caso existam src para serem preenchidos ao inves do elemtno em si
                    elements[i].setAttribute("href", info[i]);
                else if(i === 'providerPicture')
                    elements[i].src = info[i];
                else 
                    elements[i].innerHTML = info[i] // preenche o elemnto com a info 
            }

            let rateStars = template_e.querySelectorAll('.my-other-service-card--rate-div svg path'); // array com os elementos das estrlinhas de avaliacao
        
            rateStars.forEach(element => { // limpa as estrelinhas do template antes de usa-las
                element.setAttribute("fill", "#AAAA");
            });
            for(let i = 0; i < Math.floor(info.serviceRateNumber) && i < rateStars.length; i++){ // pinta de amarelo as estrelinhas de acordo com a nota
                rateStars[i].setAttribute("fill", "#FF9839")
            }

            if(info.serviceType == 0){ // verifica se o servico eh remoto
                let icon = template_e.querySelector(".my-other-service-card--location-div > i");
                icon.classList = "fas fa-laptop-house"; // coloca o icone de servico remoto
            }
        })
    }

    let itemGenerated = 0; // esta variavel armazena o index do item que devera ser mostrado a seguir, ela deve ser incrementada apos cada item ser gerado com sucesso!

    const generateNewItem = () => { // funcao que gera os itens
        let item = data[itemGenerated] // este eh o item que sera gerado
        if(! typeof item === "object") return; // se ele nao for nem do tipo certo, ja nem comeca

        otherServiceItem(item) // pede para fazer um item novo, e espera tudo ficar pronto.
            .then(() => { // se tudo deu certo e o item ja ta na DOM
                itemGenerated++; // incrementa o ndex do DATA, para ja chamar o proximo da fila

                if(itemGenerated < data.length){ // caso o proximo index ainda exista lista de dados
                    window.requestAnimationFrame(generateNewItem) // faz o proximo item
                }  
            }, (error) => {}
            )
    }

    generateNewItem();

    const centerItems= () => { // centraliza os elemtos no slider quando existe espaco sobrando
        let sliderGroup = document.querySelector('.glider.draggable');
        let gliderTrack = document.querySelector('.glider-track');

        if(gliderTrack.scrollWidth > window.innerWidth) // caso a largura do slider for maior que a janela
            sliderGroup.classList.remove('center-glider'); // centraliza
        else
            sliderGroup.classList.add('center-glider'); // descentraliza
    }

    centerItems()
    window.addEventListener('resize', centerItems)
    document.querySelector('.glider').addEventListener('glider-add', centerItems) 
}

const hireServiceHandler = () => {
    let btnHire = document.querySelector('.my-hire-service-btn');
    btnHire.onclick = () => {
        let request = new XMLHttpRequest();
        
        request.onload = () => {
            if(request.status === 200 && request.readyState === XMLHttpRequest.DONE){
                let info = JSON.parse(request.response);

                if(!info.logged){
                    let myModal = new bootstrap.Modal(document.getElementById('notLoggedModal'))
                    myModal.toggle()
                    return false;
                }

                let statusConfig = [ 
                    {
                        color:'#715c00',
                        text: 'Contrato: Pedido Pendente'
                    },
                    {
                        color:'#d82929', 
                        text: 'Serviço já contratato'
                    },
                    {
                        color:'#06A77D', 
                        text: 'Contratar serviço'
                    },
                ];

                btnHire.style.backgroundColor = statusConfig[info.status].color;
                btnHire.innerHTML = statusConfig[info.status].text;
            }
            
        }
 //data-bs-toggle="modal" data-bs-target="#notLoggedModal"
        request.open('POST', '../../../logic/contratar_servico.php');
        request.send();
    }
}
//hireServiceHandler()

descriptionHandler();

loadReportService();

dotOptionsHandler();

serviceImgIndicatorsHandler();

initializeOtherServiceSlider();

commentSectionHandler();

const loadOtherService = () => {
    let xhr = new XMLHttpRequest();

    const config = {
        getOtherServices: 'true',
        sql : {
            limit: 10
        }
    }

    xhr.open('GET', `./getAsyncData.php?getOtherServices=${JSON.stringify(config)}`);
    xhr.onload = () => {
        let resp = JSON.parse(xhr.response);

        let data = resp.getOtherServices.data;
        let dataFormated = [];

        data.forEach((elem, index) => {
            if(!elem.nota_media_servico) elem.nota_media_servico = '0';

            let fullPrice = "";

            if(!(elem.orcamento_servico == null)) fullPrice += ""+ elem.orcamento_servico;
            if(!(elem.crit_orcamento_servico == null)) fullPrice += " "+ elem.crit_orcamento_servico;

            dataFormated.push({
                link : `./visuaizarServico.php?serviceID=${elem.id_servico}`,
                providerName: elem.nome_usuario,
                serviceName: elem.nome_servico,
                providerPicture: `../../../assets/images/users/${elem.imagem_usuario}`,
                serviceRateNumber: elem.nota_media_servico || 0,
                serviceLoaction: elem.cidade_usuario,
                serviceType: elem.tipo_servico, // remoto ou presencial
                servicePrice: fullPrice,
            });
        
        });

        initializeOtherServiceSlider(dataFormated); // manda para a funcao que vai fazer tudo com esses dados
    }

    xhr.send();
}

loadOtherService();

const saveService = () => {
    let unsavedSVG = `
    
        <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_10_40)">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.125 39.7188V5.125C5.125 3.76577 5.66495 2.4622 6.62608 1.50108C7.5872 0.539954 8.89077 0 10.25 0L30.75 0C32.1092 0 33.4128 0.539954 34.3739 1.50108C35.335 2.4622 35.875 3.76577 35.875 5.125V39.7188C35.8752 39.9412 35.8174 40.1599 35.7073 40.3533C35.5973 40.5467 35.4388 40.7081 35.2475 40.8216C35.0561 40.9351 34.8385 40.9969 34.616 41.0007C34.3936 41.0046 34.1739 40.9505 33.9788 40.8437L20.5 33.4893L7.02125 40.8437C6.82606 40.9505 6.60643 41.0046 6.38397 41.0007C6.16151 40.9969 5.94389 40.9351 5.75254 40.8216C5.56118 40.7081 5.40268 40.5467 5.29265 40.3533C5.18262 40.1599 5.12484 39.9412 5.125 39.7188ZM27.8134 15.0009C28.054 14.7603 28.1891 14.434 28.1891 14.0938C28.1891 13.7535 28.054 13.4272 27.8134 13.1866C27.5728 12.946 27.2465 12.8109 26.9062 12.8109C26.566 12.8109 26.2397 12.946 25.9991 13.1866L19.2188 19.9696L16.2821 17.0304C16.163 16.9112 16.0216 16.8168 15.8659 16.7523C15.7103 16.6878 15.5435 16.6546 15.375 16.6546C15.2065 16.6546 15.0397 16.6878 14.8841 16.7523C14.7284 16.8168 14.587 16.9112 14.4679 17.0304C14.3488 17.1495 14.2543 17.2909 14.1898 17.4466C14.1253 17.6022 14.0921 17.769 14.0921 17.9375C14.0921 18.106 14.1253 18.2728 14.1898 18.4284C14.2543 18.5841 14.3488 18.7255 14.4679 18.8446L18.3116 22.6884C18.4306 22.8077 18.572 22.9024 18.7277 22.9669C18.8833 23.0315 19.0502 23.0648 19.2188 23.0648C19.3873 23.0648 19.5542 23.0315 19.7098 22.9669C19.8655 22.9024 20.0069 22.8077 20.1259 22.6884L27.8134 15.0009Z" fill="#3333CC"/>
    </g>
    <defs>
    <clipPath id="clip0_10_40">
    <rect width="41" height="41" fill="white"/>
    </clipPath>
    </defs>
    </svg>


       
    `;

    let savedSVG = `
    
    <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M5.125 5.125C5.125 3.76577 5.66495 2.4622 6.62608 1.50108C7.5872 0.539954 8.89077 0 10.25 0L30.75 0C32.1092 0 33.4128 0.539954 34.3739 1.50108C35.335 2.4622 35.875 3.76577 35.875 5.125V39.7188C35.8749 39.9505 35.8119 40.1779 35.6928 40.3767C35.5736 40.5755 35.4028 40.7382 35.1985 40.8476C34.9942 40.957 34.764 41.0089 34.5325 40.9979C34.301 40.9868 34.0769 40.9131 33.8839 40.7848L20.5 33.5713L7.11606 40.7848C6.92312 40.9131 6.69897 40.9868 6.46747 40.9979C6.23598 41.0089 6.00582 40.957 5.8015 40.8476C5.59718 40.7382 5.42636 40.5755 5.30723 40.3767C5.1881 40.1779 5.12512 39.9505 5.125 39.7188V5.125ZM10.25 2.5625C9.57038 2.5625 8.9186 2.83248 8.43804 3.31304C7.95748 3.7936 7.6875 4.44538 7.6875 5.125V37.3254L19.7902 30.9652C20.0005 30.8253 20.2474 30.7507 20.5 30.7507C20.7526 30.7507 20.9995 30.8253 21.2098 30.9652L33.3125 37.3254V5.125C33.3125 4.44538 33.0425 3.7936 32.562 3.31304C32.0814 2.83248 31.4296 2.5625 30.75 2.5625H10.25Z" fill="#3333CC"/>
    </svg>
    
    `;
    
    let btnSave = document.querySelectorAll('.my-save-service-btn');
    let labelSave = document.querySelectorAll('.save-service-label p');
    const saveResponseRandler = (response, index) => {
      
        let data = JSON.parse(response);
        if(data.saveService.allRight){
            if(data.saveService.inserted){
                btnSave[index].innerHTML = unsavedSVG;
                labelSave.forEach(elem => {elem.innerHTML = "Descartar"});
            }
            else if(data.saveService.deleted){
                btnSave[index].innerHTML = savedSVG;
                labelSave.forEach(elem => {elem.innerHTML = "Salvar"});
            }
        }
    }

    const config = {
        saveService : 'true'
    }
    
    btnSave.forEach((elem, index) => {
        elem.onclick = () => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "./getAsyncData.php");

            xhr.onload = () => {
                if(xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE ){
                    saveResponseRandler(xhr.response, index)
                }
            };

            xhr.send(JSON.stringify(config));

        }
    });

    
}
saveService();

async function getOtherServicesData() { // pega os dados de 'outros serviços'
    let otherServiceData = [ // modelo de array que deve ser retronado pelo backend
        {
            link: '#',
            providerName: '01',
            serviceName: 'T 01',
            providerPicture: 'https://picsum.photos/80?random=1',
            serviceRateNumber: '01',
            serviceLoaction: 'São Bernardo 01',
            servicePrice: 'Orçamento',
        },
        {
            link: '#',
            providerName: '02',
            serviceName: 'Técnico 02 ',
            providerPicture: 'https://picsum.photos/2000?random=2',
            serviceRateNumber: '02',
            serviceLoaction: 'São 02',
            servicePrice: 'Orçamento',
        },
        {
            link: '#',
            providerName: '03',
            serviceName: 'de 03',
            providerPicture: 'https://picsum.photos/2000?random=3',
            serviceRateNumber: '03',
            serviceLoaction: 'São 03',
            servicePrice: 'Orçamento',
        },
        {
            link: '#',
            providerName: '04',
            serviceName: 'Técnico 04',
            providerPicture: 'https://picsum.photos/2000?random=4',
            serviceRateNumber: '04',
            serviceLoaction: 'São 04',
            servicePrice: 'Orçamento',
        },
        {
            link: '#',
            providerName: '05',
            serviceName: 'Técnico 05',
            providerPicture: 'https://picsum.photos/2000?random=5',
            serviceRateNumber: '05',
            serviceLoaction: 'São Bernardo 05',
            servicePrice: 'Orçamento',
        },
        {
            link: '#',
            providerName: '06',
            serviceName: 'Técnico 06',
            providerPicture: 'https://picsum.photos/2000?random=6',
            serviceRateNumber: '06',
            serviceLoaction: 'São Bernardo do campo',
            servicePrice: 'Orçamento',
        },
    ];

    await fetch('https://jsonplaceholder.typicode.com/posts') // simulação de delay - aqui deveria ser feita a requisicao do array mostrado acima
        .then(() => { // quando terminar, pega os dados e manda cuidar disso
            initializeOtherServiceSlider(otherServiceData); // manda para a funcao que vai fazer tudo com esses dados
        })
}

async function getCommentsData01 () {
    let commentsDataold = [
        {
            profilePicture: 'https://picsum.photos/1000?random=100',
            rateStars : 5,
            publishDate: '2021-06-06 22:55:46',
            text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis sit dicta ipsam quas esse nemo at amet quasi alias nisi. Voluptate excepturi enim eaque optio reprehenderit illo veniam distinctio autem porro quod in odio impedit fugit, repellendus minima nobis assumenda ea. Architecto possimus, maxime obcaecati consectetur ipsam unde sint deserunt rerum culpa itaque tenetur labore error, perspiciatis commodi earum reprehenderit. Excepturi tempora sint quaerat eius nobis quos illum fugiat, fugit est esse expedita dolorem magni laboriosam quasi, consectetur officia, cumque vitae ipsa? Sunt, vitae quo ut '
        },
        {
            profilePicture: 'https://picsum.photos/2000?random=101',
            rateStars : 4,
            publishDate: '2021-06-06 22:55:46',
            text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec libero a leo mattis imperdiet. Vivamus eleifend ipsum et erat efficitur, non porttitor est ultricies. Nunc mauris est, gravida ac odio eu, vulputate venenatis leo.',
        },
        {
            profilePicture: 'https://picsum.photos/2000?random=102',
            rateStars : 4,
            publishDate: '2021-06-06 22:55:46',
            text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec libero a leo mattis imperdiet. Vivamus eleifend ipsum et erat efficitur, non porttitor est ultricies. Nunc mauris est, gravida ac odio eu, vulputate venenatis leo.',
        },
    ];

    await fetch('https://jsonplaceholder.typicode.com/users') // simulação de delay - aqui deveria ser feita a requisicao do array mostrado acima
        .then(response => response.json())
        .then((data) => {   


            let commentsData = [
                {
                    userName: data[Math.floor(Math.random() * 10)].name,
                    profilePicture: 'https://picsum.photos/1000?random=100',
                    rateStars : Math.random() * 5,
                    publishDate: '2021-06-06 22:55:46',
                    text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis sit dicta ipsam quas esse nemo at amet quasi alias nisi. Voluptate excepturi enim eaque optio reprehenderit illo veniam distinctio autem porro quod in odio impedit fugit, repellendus minima nobis assumenda ea. Architecto possimus, maxime obcaecati consectetur ipsam unde sint deserunt rerum culpa itaque tenetur labore error, perspiciatis commodi earum reprehenderit. Excepturi tempora sint quaerat eius nobis quos illum fugiat, fugit est esse expedita dolorem magni laboriosam quasi, consectetur officia, cumque vitae ipsa? Sunt, vitae quo ut '
                },
                {
                    userName: data[Math.floor(Math.random() * 10)].name,
                    profilePicture: 'https://picsum.photos/2000?random=101',
                    rateStars : Math.random() * 5,
                    publishDate: '2021-06-06 22:55:46',
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec libero a leo mattis imperdiet. Vivamus eleifend ipsum et erat efficitur, non porttitor est ultricies. Nunc mauris est, gravida ac odio eu, vulputate venenatis leo.',
                },
                {
                    userName: data[Math.floor(Math.random() * 10)].name,
                    profilePicture: 'https://picsum.photos/2000?random=102',
                    rateStars : Math.random() * 5,
                    publishDate: '2021-06-06 22:55:46',
                    text: 'Meu comentario kkkkk'
                },
            ];
            
            commentSectionHandler(commentsData); // manda para a funcao que vai fazer tudo com esses dados
        });
}

loadCommentsData();

const refreshAverageRate = (data) => {
    if(!data.info.finished) return false;
    
    const refreshProviderRate = (providerInfo) => {
        let lbl_rate = document.querySelectorAll('.provider-rate--number');
        lbl_rate.forEach(elem => {
            elem.innerHTML = Number(providerInfo.averageRate).toFixed(1);
        });

        let rateSatrs = document.querySelectorAll('.provider-rate--stars svg path');
        rateSatrs.forEach(elem => {
            elem.setAttribute("fill", "#AAAA");
        });
        for(let i = 0; i < Math.round(providerInfo.averageRate) && i < rateSatrs.length; i++){
            rateSatrs[i].setAttribute("fill", "#FF9839");
        }
        let lbl_rateQuantity = document.querySelectorAll('.provider-rate--quantity');
        lbl_rateQuantity.forEach(elem => {
            elem.innerHTML = `(${providerInfo.rateQuantity} - ${providerInfo.rateQuantity === 1 ? 'avaliação' : 'avaliações'})`;
        });
    }

    const refrechServiceRate = (serviceInfo) => {
        let lbl_rate = document.querySelectorAll('.service-rate--number ');
        lbl_rate.forEach(elem => {
            elem.innerHTML = Number(serviceInfo.averageRate).toFixed(1);
        });

        let rateSatrs = document.querySelectorAll('.my-rate-service-info .service-rate--stars svg path');
        rateSatrs.forEach(elem => {
            elem.setAttribute("fill", "#AAAAA");
        });

        for(let i = 0; i < Math.round(serviceInfo.averageRate) && i < rateSatrs.length; i++){
            rateSatrs[i].setAttribute("fill", "#FF9839");
        }
        let lbl_rateQuantity = document.querySelectorAll('.service-rate--quantity');
        lbl_rateQuantity.forEach(elem => {
            elem.innerHTML = `(${serviceInfo.rateQuantity} - ${serviceInfo.rateQuantity === 1 ? 'avaliação' : 'avaliações'})`;
        });
    }
    refrechServiceRate(data.service);
    refreshProviderRate(data.provider);
}

async function loadCommentsData(){
    const config = {
        averageRate : 'true',
        comments : 'true',
    };

    let xhr = new XMLHttpRequest();
    xhr.onload = () => {
        if(xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE ){
            let data = xhr.response;
            commentsDataHandler(JSON.parse(data).comments);

            if(config.averageRate) refreshAverageRate(JSON.parse(data).averageRate);
        }
    }

    xhr.open("POST", "./getAsyncData.php");
    xhr.send(JSON.stringify(config));
}

async function commentsDataHandler(response){
    let data = response;
    let commentsData = [];
    let commentQuantity = 0;
    let rateSum = 0;

    let pictureFolderPath = "../../../assets/images/users/";

    if(data.length > 0) document.querySelector("#myComentSection").style.display = "block";

    data.forEach((elem, index) => {
        commentsData.push({
            // userName: `${elem.user.nome_usuario}  ${elem.user.sobrenome_usuario}`,
            // profilePicture: pictureFolderPath + elem.user.imagem_usuario,
            // rateStars : elem.comment.nota_comentario,
            // publishDate: elem.comment.data_comentario,
            // text: elem.comment.desc_comentario,
            // commentId: elem.comment.id_comentario
            userName: `${elem.nome_usuario}  ${elem.sobrenome_usuario}`,
            profilePicture: pictureFolderPath + elem.imagem_usuario,
            rateStars : elem.nota_comentario,
            publishDate: elem.data_comentario,
            text: elem.desc_comentario,
            commentId: elem.id_comentario
        });
        commentQuantity++;

        if(elem.nota > 5) elem.nota = 5;
        rateSum += elem.nota * 1;
    });
    commentSectionHandler(commentsData);


    let rateServiceDiv = document.querySelector('.my-rate-service-info');
    rateServiceDiv.classList.remove('loading');
}
async function getCommentsData00(){
    let commentsData = [];
    let commentQuantity = 0;
    let rateSum = 0;

    let xhr = new XMLHttpRequest();
    xhr.onload = () => {
        if(xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE){
            let data = xhr.response;
           // console.log(data);

            data = JSON.parse(data);

            let pictureFolderPath = "./images/";

            data.forEach((elem, index) => {
                commentsData.push({
                    userName: `${elem.user.nome_usuario}  ${elem.user.sobrenome_usuario}`,
                    profilePicture: pictureFolderPath + elem.user.imagem_usuario,
                    rateStars : elem.comment.nota,
                    publishDate: elem.comment.data,
                    text: elem.comment.comentario
                });
                commentQuantity++;

                if(elem.comment.nota > 5) elem.comment.nota = 5;
                rateSum += elem.comment.nota * 1;
            });

            commentSectionHandler(commentsData);

            let rateServiceDiv = document.querySelector('.my-rate-service-info');
            rateServiceDiv.classList.remove('loading');
        }

        
    }

    xhr.open("GET", "./getAsyncData.php");
    xhr.send();
}

//getOtherServicesData();
let hireServiceForm = document.querySelectorAll('#hideServiceForm');
hireServiceForm.forEach((elem) => {
    elem.addEventListener('submit', event => {
        event.preventDefault();
        let formData = new FormData(event.target);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../logic/ocultar_servico.php')
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200){
                if (xhr.response == 1 || xhr.response == 3){
                    document.getElementById('btnHide').innerText = xhr.response == 3 ? 'Voltar a exibir serviço' : 'Suspender serviço'
                    if (xhr.response == 3){
                        let hideServiceObs = document.createElement('small')
                        hideServiceObs.className = 'text-danger'
                        hideServiceObs.id = 'hideServiceObs'
                        hideServiceObs.innerText = 'Seu serviço atualmente não está sendo mostrado para o público'
                        document.getElementById('hideServiceForm').appendChild(hideServiceObs)
                    } else {
                        document.getElementById('hideServiceObs').remove()
                    }
                }
            }
        }
        xhr.send(formData)
    })
});


export {commentsDataHandler, refreshAverageRate};