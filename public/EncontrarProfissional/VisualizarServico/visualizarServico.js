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

const initializeOtherServiceSlider =(data = []) => { // cuida da listagem de outros servicos

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

    const otherServiceItem = (info = {}) => { // cuida do preenchimento e aplicacao na DOM de cada servico
        let template_e = document.getElementById('myOtherServiceTemplate'); // este e o template do item
        let list_e = document.getElementsByClassName('glider')[0]; // esta e a lista onde serao colocaldos os itens

        let elements = { // contem os elmentos do temlate
            link: template_e.content.querySelector('.my-other-service-link'),
            providerName: template_e.content.querySelector('.my-other-service-card--provider-name'),
            serviceName: template_e.content.querySelector('.my-other-service-card--service-name'),
            providerPicture: template_e.content.querySelector('.my-other-service--person-picture'),
            serviceRateNumber: template_e.content.querySelector('.my-rate-service-number > label'),
            serviceLoaction: template_e.content.querySelector('.my-other-service-location'),
            servicePrice: template_e.content.querySelector('.my-other-service-price'),
        }

        for(let i in elements){ // percorre todos os elemtnos que deverao ser preenchidos
            if(!info[i]) { // caso nao tenha sido enviada a inforamacao para ser preenchido o cartao. O modelo do objeto a ser recebido eh o mesmo de {elements}
                console.log("faltam informacoes para preencher o cartao de outros servicos")
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

        let newItem = document.importNode(template_e.content, true); // cria-se um node com as devidas informacoes
        //list_e.appendChild(newItem); // insere o node na lista 

        otherServicesSlider.addItem(newItem); // insere o node na lista - pelo metodo do glider.js
    }

    data.forEach((item) => {
        if(! typeof item === "object") return
        try {
            otherServiceItem(item)
        } catch (error) {
            console.log(error)
        }
    })

   /* for(let i = 0; i< 10; i++){ // exemplo de chamda de criacao dos itens do other service
        otherServiceItem(
            {
                link: '#',
                providerName: 'Luís Carlos',
                serviceName: 'Técnico de T.I',
                providerPicture: '../../../assets/images/profile_images/teste.jpeg',
                serviceRateNumber: '2.6',
                serviceLoaction: 'São Bernardo do campo',
                servicePrice: 'Orçamento',
            }
        );
    }*/

    const  centerItems= () => { // centraliza os elemtos no slider quando existe espaco sobrando
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

reportHandler();

dotOptionsHandler();

serviceImgIndicatorsHandler();

initializeOtherServiceSlider();

let otherServiceData = [
    {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: 'http://www.etelg.com.br/paginaete/cursos/ifi/index/Internet/Menus/mat/professores/LC.jpg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    }, {
        link: '#',
        providerName: 'Luís Carlos',
        serviceName: 'Técnico de T.I',
        providerPicture: '../../../assets/images/profile_images/teste.jpeg',
        serviceRateNumber: '2.6',
        serviceLoaction: 'São Bernardo do campo',
        servicePrice: 'Orçamento',
    },
];
initializeOtherServiceSlider(otherServiceData);


