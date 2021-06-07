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


const descriptionHandler = () => {
    const btnToggler = document.getElementById("myDescriptionToggleLabel");
    let description_e = document.getElementById("myDescriptionText");
    const txtDescription = description_e.innerText;

    let maxCaracter = 200; // numero maximo de caracteres por fatia do texto
    maxCaracter = window.innerHeight * 0.5;
    let btnStatus = 0; // e o campo do array que sera mostrado

    let splitText = []; // este array comporta em cada campo uma fatia do texto determinada pelo maxCaracter
    const splitQuantity = Math.floor(txtDescription.length / maxCaracter); 
    for(let i = 0; i < splitQuantity; i++){
        let textInitial = (i + 1) * splitQuantity;
        splitText[i] = txtDescription.slice(textInitial, textInitial + maxCaracter + 1);
    }

    description_e.innerText = splitText[0]; // esta e a primeira a ser rodada, com o maxCaracter

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

const reportHandler = () => {
    let iframe_e = document.getElementById("myReportIframe");

    let modal = document.getElementById("myReportModalBody");

    let reportInterface = new ReportInterface(iframe_e);
    reportInterface.getInfo(
       /* {
            serviceName: 'nome_do_servico', providerName : 'nome_do_provedor', reportReason: ['a', 'b', 'c', 'd']
        }*/
       {
            smallBusiness: 'nome_do_negocio', reportReason: ['a']
        }
    );

    let structure = reportInterface.getStructure()[0];
    //console.log(structure)
   
     modal.appendChild(structure)
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

            moreOpstionHandler();
            readMoreHandler();
            publishDateHandler();
            
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
                console.groupCollapsed("faltam informacoes para preencher o comentario")
                    console.log('array total --> ', info)
                    console.log('elemento --> ', info)
                    console.log('index --> ', i)
                console.groupEnd();
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
            let template_e = document.getElementById('myOtherServiceTemplate'); // este e o template do item

            let elements = { // contem os elmentos do temlate
                link: template_e.content.querySelector('.my-other-service-link'),
                providerName: template_e.content.querySelector('.my-other-service-card--provider-name'),
                serviceName: template_e.content.querySelector('.my-other-service-card--service-name'),
                providerPicture: document.createElement('img'), // o elemnto img eh criado pelo js porque deve-se esperar a img carregar para mostrar o item
                serviceRateNumber: template_e.content.querySelector('.my-rate-service-number > label'),
                serviceLoaction: template_e.content.querySelector('.my-other-service-location'),
                servicePrice: template_e.content.querySelector('.my-other-service-price'),
            }

            elements.providerPicture.onload = () => { // quando a imagem do prestador carregar tudo
                try{ // junta tudo e poe na DOM

                    elements.providerPicture.classList.add('my-other-service--person-picture'); // adiciona as classes ao elemento img criado pelo js.
                    elements.providerPicture.setAttribute('alt', 'Foto de perfil') // adiciona um alt no img criaod pelo js 
    
                    let photoContainer = template_e.content.querySelector('.my-other-service--person-picture-div'); // esta eh a div onde sera colocada o le,ento img criado pelo js 
                    photoContainer.innerHTML = ""; // limpar ela antes de usar, pois as imagens de itens anteriores ficam aqui ainda.
                    photoContainer.appendChild(elements.providerPicture); // coloca o img criado pelo js 
    
                    let newItem = document.importNode(template_e.content, true); // cria-se um node com as devidas informacoes
    
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
                if(!info[i]) { // caso nao tenha sido enviada a inforamacao para ser preenchido o cartao. O modelo do objeto a ser recebido eh o mesmo de {elements}
                    console.groupCollapsed("faltam informacoes para preencher o cartao de outros servicos")
                        console.log('array total --> ', info)
                        console.log('elemento --> ', info)
                        console.log('index --> ', i)
                    console.groupEnd();
                    return;
                };

                if(i === 'link' || i === 'providerPicture') // caso existam src para serem preenchidos ao inves do elemtno em si
                    elements[i].src = info[i];
                else
                    elements[i].innerHTML = info[i] // preenche o elemnto com a info 
            }

            let rateStars = template_e.content.querySelectorAll('.my-other-service-card--rate-div svg path'); // array com os elementos das estrlinhas de avaliacao
            for(let i = 0; i < Math.floor(info.serviceRateNumber) && i < rateStars.length; i++){ // pinta de amarelo as estrelinhas de acordo com a nota
                rateStars[i].setAttribute("fill", "#FF9839")
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
            }, (error) => {
                console.log("error: ")
                console.log(error)
            }
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

writeCommentResizeTextArea();

descriptionHandler();

//reportHandler();

dotOptionsHandler();

serviceImgIndicatorsHandler();

initializeOtherServiceSlider();

commentSectionHandler();


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

async function getCommentsData () {
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
getCommentsData();
getOtherServicesData();

  

