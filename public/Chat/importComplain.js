import ReportInterface from "../Denuncia/denuncia.js";

function serviceComplain(element) {
    console.log(element)
    let user = element.getAttribute('providerName');
    let service = element.getAttribute('serviceName');
    let modal = document.querySelector('#serviceComplainModal');
    let modalBody = document.querySelector('#serviceComplainModalBody')
    let modalTrigger = element

    modalBody.innerHTML = ""

    const reportHandler = async () => { // envia os valores para a fcnao que gera e retorna o elemtno de denuncia para adicionar no modal
        let iframeNode;
        const getNode = async () => { // busca o node por ajax
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '../Denuncia/denuncia.php');
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
            let processedNode = await ReportInterface({node:iframeNode, type: 'service', data: {service, user}})
            await modalTrigger.setAttribute('data-bs-toggle',`modal`)
            await modalTrigger.setAttribute('data-bs-target',`#serviceComplainModal`)
            await modalBody.appendChild(processedNode) // pega o node retornado e o coloca na DOM
        }
    }
    reportHandler()
}