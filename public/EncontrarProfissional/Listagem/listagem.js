const toggleCategoriesSidebar = () => {
    let state = {
        selected: false
    };
    let backdrop = document.querySelector('.categories-backdrop');
    let sidebar = document.querySelector('.categoriesSection');
    let btnToggler = document.querySelectorAll('.my-categories-toggle-btn');
    let body = document.querySelector('body');

    const refresShowSidebar = () => {
       
        if(state.selected){
            sidebar.classList.add('show-sidebar');
            sidebar.classList.remove('hide-sidebar');

            backdrop.classList.add('show');
            body.style.overflow = "hidden";
        }
        else{
            sidebar.classList.add('hide-sidebar');
            sidebar.classList.remove('show-sidebar');

            backdrop.classList.remove('show');
            body.style.overflow = "auto";
            console.log(body.style.overflow)
        }
    }

    refresShowSidebar();

    const refreshAll = () => {
        console.log(state)
        refresShowSidebar();
    }

    const setState = (obj) => {
        if(!typeof obj === 'object')
            return;

        for(let i in obj){
            state[i] = obj[i]
        }

        refreshAll();
    }

    const btnTogglerHandler = () => {
        let tempSate = !state.selected;
        setState({selected: tempSate});

        document.querySelector('.categoriesSection').style.transition = "transform 0.5s";
    }

    backdrop.onclick = () => {
        let tempState = state.selected;
        setState({selected: !tempState});
    }

    btnToggler.forEach((toggler) => {
        toggler.onclick = btnTogglerHandler;
    });

};

toggleCategoriesSidebar();

const categoriesScrollHandler = () => {
    document.querySelector(".categoriesSection").scrollTop = 0;
    document.querySelector(".categoriesSectionBody").scrollTop = 0;
    
}

const mediumScreen = window.matchMedia("(min-width: 768px)");
categoriesScrollHandler();
mediumScreen.addListener(categoriesScrollHandler);

const fillCategories = (data) => {
    if(!typeof data === 'array') return;

    let listPath = document.querySelector('.categoriesSectionBody');

    const categorieItem = (item) => {
        let categorieNode = document.importNode(document.querySelector("#myCategorieItemTemplate").content, true);
        let subCategorieNode = document.importNode(document.querySelector("#mySUBCategorieItemTemplate").content, true);

        if(! typeof item === 'object') return;

        let DOM = {
            categorie : {
                name: categorieNode.querySelector('.categorieName'),
                arrow: categorieNode.querySelector('.categorieArrow')
            },
            subCategorie: {
                title: subCategorieNode.querySelector('.subCategorie-section-title'), 
                body: subCategorieNode.querySelector('.subCategorieBody'),
                subItem: subCategorieNode.querySelector('.subCategorie-item'),
                subItemTitle: subCategorieNode.querySelector('.subCategorie-title')
            }
        }

        DOM.categorie.name.innerHTML = item.categorie.title;
        DOM.subCategorie.title.innerHTML = item.categorie.title;
        let subCategorieItems = [];
        
        item.categorie.subItems.forEach((subItem, index) => {
            let subItem_e = document.importNode(DOM.subCategorie.subItem, true);
            let subTitle_e = subItem_e.querySelector('.subCategorie-title');
            
            subTitle_e.innerHTML = subItem.title;
            if((index + 1) % 2 === 0){
                subTitle_e.classList.add('right-col');
                subTitle_e.classList.remove('left-col');
            }
            else{
                subTitle_e.classList.add('left-col');
                subTitle_e.classList.remove('right-col');
            }

            subCategorieItems.push(subItem_e);
        });

        const addFunctions = (item) => {
            let categorieDiv = item.querySelector('.categorie-item');
            let subCategorieDiv = item.querySelector('.subcategorie-container');
            let arrow = item.querySelector('.categorieArrow');

            categorieDiv.onclick = () => {
                let active = false;
                if(subCategorieDiv.classList.contains('subcategorie-active')){
                    active = true;
                }

                let DOMsubcategories = document.querySelectorAll('.subcategorie-container');
                DOMsubcategories.forEach((elem) => {
                    elem.classList.remove('subcategorie-active');
                });
                let DOMcategories = document.querySelectorAll('.categorie-item');
                DOMcategories.forEach((elem) => {
                    elem.classList.remove('categorie-item-active');
                });
                let DOMarrows = document.querySelectorAll('.categorieArrow');
                DOMarrows.forEach((elem) => {
                    elem.classList.remove('rotate-categorie-item');
                });

                if(!active){
                    subCategorieDiv.classList.add('subcategorie-active');
                    categorieDiv.classList.add('categorie-item-active');
                    arrow.classList.add('rotate-categorie-item')
                }

                
            }
        }
        

        DOM.subCategorie.body.innerHTML = "";
        subCategorieItems.forEach((elem) => {
            DOM.subCategorie.body.appendChild(elem);
        });
        

        // console.log({categorieNode})
        // console.log(categorieNode)
        // console.log(subCategorieNode)

        let wrapper = document.createElement('div');
        wrapper.classList.add('wrapper-categorie-subcategorie');
        wrapper.append(categorieNode, subCategorieNode);

        addFunctions(wrapper);

        return wrapper;
    }

    // const bla = [
    //     {
    //         categorie : {
    //             title: "categorieName",
    //             subItems : [
    //                 {title: 'subCategorie1'},
    //                 {title: 'subCategorie1'},
    //                 {title: 'subCategorie1'},
    //             ]
    //         }
    //     }
    // ]

    data.forEach((item) => {
        listPath.appendChild(categorieItem(item));
    });
}

const serviceCardsRender = (data) => {
    if(! (typeof data === 'object')){
        console.log('[serviceCardsRender] --> wrong type of data');
        return;
    }

    let serviceCard_e = document.querySelector('#serviceCardTemplate').content;
    let serviceCadrPath_e = document.querySelector('.service-cards-path');

    const serviceCard = (info) => {
        if(! (typeof info === 'object')){
            console.log('[serviceCard] --> wrong type of data');
            return;
        }

        let node = document.importNode(serviceCard_e, true);
        console.log(node)

        let structureDOM = {
            providerName: node.querySelector('.service-card-provider-name'),
            serviceName: node.querySelector('.service-card--service-name'),
            location: node.querySelector('.service-location'),
            price: node.querySelector('.service-card--price')
        };

        let structureData = {
            serviceID: '',
            imgSRC: '',
            avaliation: '',
        }

        const dataHandler = () => {
            let nodeLink = node.querySelector('.service-card-link');
            let link = `../VisualizarServico/visuaizarServico.php?serviceID=${structureData.serviceID}`;
            nodeLink.href = link;

            let stars = node.querySelectorAll('.service-card--rate-stars path');

            stars.forEach(star => {
                star.setAttribute('fill', '#ccc');
            })
            for(let i = 0; i < Math.round(structureData.avaliation) && i < stars.length; i++){
                stars[i].setAttribute('fill', '#FF9839');
            }
            node.querySelector('.service-card--avaliation-quantity').innerHTML = `(${structureData.avaliation.toFixed(2)})`;

            console.log({node})
            const imgHandler = () => {
                let profileIMG = new Image();
                profileIMG.classList.add('service-card--profile-img');
                let imgDiv = node.querySelector('.service-card--profile-img-div');

                profileIMG.onload = () => {
                    console.log({node})
                    imgDiv.innerHTML = "";
                    imgDiv.appendChild(profileIMG);
                    imgDiv.classList.remove('loading');
                };

                profileIMG.src = structureData.imgSRC;

            }

            imgHandler();
        }

        const fillData = () => {
            for(let i in structureData){
                if(info[i]) structureData[i] = info[i];
            }

            dataHandler();
        }

        for(let i in structureDOM){
            if(info[i]) structureDOM[i].innerHTML = info[i];
        }

        fillData();

        return node;
        
    }

    data.forEach(item => {
        let node = serviceCard(item);
        console.log({node})
        serviceCadrPath_e.appendChild(node);
    });

}

const serviceCardData = [
    {
        serviceID: '10',
        imgSRC: 'https://picsum.photos/2000?random=1',
        location: 'rua pequetita vila olimpia',
        serviceName: 'nome do servico kk',
        providerName: 'nome do cara lá',
        avaliation: 2.49,
        avaliationQuant: 90,
        price: '30 por cabeça'
    },
    {
        serviceID: '10',
        imgSRC: 'https://picsum.photos/2000?random=2',
        location: 'rua pequetita vila olimpia',
        serviceName: 'nome do servico kk 2',
        providerName: 'nome do cara lá',
        avaliation: 5.49,
        avaliationQuant: 90,
        price: '30 por hora'
    },
];
serviceCardsRender(serviceCardData)



const categories = [
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    {
        categorie : {
            title: "pato ultimo",
            subItems : [
                {title: 'sub pato w'},
                {title: 'sub pato 2'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
                {title: 'subpato 23'},
            ]
        }
    },
    
];

fillCategories(categories);
