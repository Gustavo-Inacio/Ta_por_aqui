$(function () {
    $('[data-toggle="popover"]').popover()
})

function createUserClassChart(qntCliets, qntProviders) {
    let ctx = document.getElementById('userClassChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['clientes', 'prestadores'],
            datasets: [{
                label: 'Clientes e prestadores',
                data: [qntCliets, qntProviders],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createUserSexChart(masc, fem, other) {
    let ctx = document.getElementById('userSexChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['feminino', 'masculino', 'outros'],
            datasets: [{
                label: 'Mulheres, homens e outros',
                data: [fem, masc, other],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(235,226,54,0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgb(223,235,54)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createServicesChart(pres, remot) {
    let ctx = document.getElementById('serviceChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['presencial', 'remoto'],
            datasets: [{
                label: 'Serviços remotos e presenciais',
                data: [pres, remot],
                backgroundColor: [
                    'rgba(128,255,99,0.2)',
                    'rgba(54,90,235,0.2)'
                ],
                borderColor: [
                    'rgb(115,255,99)',
                    'rgb(54,57,235)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createContractsChart(pending, accept, reject) {
    let ctx = document.getElementById('contractChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['pendente', 'aceito', 'rejeitado'],
            datasets: [{
                label: 'Contratos pendentes, aceitos ou rejeitados',
                data: [pending, accept, reject],
                backgroundColor: [
                    'rgba(82,82,82,0.2)',
                    'rgba(128,255,99,0.2)',
                    'rgba(235,54,54,0.2)'
                ],
                borderColor: [
                    'rgb(82,82,82)',
                    'rgb(115,255,99)',
                    'rgb(235,54,54)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createTopServicesChart(...values){
    let labels = [];
    let data = [];
    for (let i in values) {
        if (typeof values[i] === 'string'){
            labels.push(values[i])
        } else if (typeof values[i] === 'number'){
            data.push(values[i])
        }
    }
    let ctx = document.getElementById('topServicesChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Serviços mais populares',
                data: data,
                backgroundColor: [
                    'rgba(128,255,99,0.2)',
                    'rgba(99,255,250,0.2)',
                    'rgba(190,54,235,0.2)',
                    'rgba(235,108,54,0.2)',
                    'rgba(235,199,54,0.2)'
                ],
                borderColor: [
                    'rgb(115,255,99)',
                    'rgb(99,255,250)',
                    'rgb(190,54,235)',
                    'rgb(235,108,54)',
                    'rgb(235,199,54)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createTopCategoriesChart(...values){
    let labels = [];
    let data = [];
    for (let i in values) {
        if (typeof values[i] === 'string'){
            labels.push(values[i])
        } else if (typeof values[i] === 'number'){
            data.push(values[i])
        }
    }

    let ctx = document.getElementById('topCategoriesChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Categorias mais escolhidas',
                data: data,
                backgroundColor: [
                    'rgba(128,255,99,0.2)',
                    'rgba(99,255,250,0.2)',
                    'rgba(190,54,235,0.2)',
                    'rgba(235,108,54,0.2)',
                    'rgba(235,199,54,0.2)'
                ],
                borderColor: [
                    'rgb(115,255,99)',
                    'rgb(99,255,250)',
                    'rgb(190,54,235)',
                    'rgb(235,108,54)',
                    'rgb(235,199,54)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createMostCommonExitsChart(...values){
    let labels = [];
    let data = [];
    for (let i in values) {
        if (typeof values[i] === 'string'){
            labels.push(values[i])
        } else if (typeof values[i] === 'number'){
            data.push(values[i])
        }
    }

    for (let i in labels){
        if (labels[i].length > 25){
            labels[i] = labels[i].slice(0,25) + "..."
        }
    }

    let ctx = document.getElementById('mostCommonExitsChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Motivos de exclusão de conta',
                data: data,
                backgroundColor: [
                    'rgba(128,255,99,0.2)',
                    'rgba(99,255,250,0.2)',
                    'rgba(190,54,235,0.2)',
                    'rgba(235,108,54,0.2)',
                    'rgba(235,199,54,0.2)'
                ],
                borderColor: [
                    'rgb(115,255,99)',
                    'rgb(99,255,250)',
                    'rgb(190,54,235)',
                    'rgb(235,108,54)',
                    'rgb(235,199,54)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createMostCommonServiceComplainsChart(...values){
    let labels = [];
    let data = [];
    for (let i in values) {
        if (typeof values[i] === 'string'){
            labels.push(values[i])
        } else if (typeof values[i] === 'number'){
            data.push(values[i])
        }
    }

    let ctx = document.getElementById('mostCommonServiceComplainsChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Motivos de denúncia de serviço',
                data: data,
                backgroundColor: [
                    'rgba(128,255,99,0.2)',
                    'rgba(99,255,250,0.2)',
                    'rgba(190,54,235,0.2)',
                    'rgba(235,108,54,0.2)',
                    'rgba(235,199,54,0.2)'
                ],
                borderColor: [
                    'rgb(115,255,99)',
                    'rgb(99,255,250)',
                    'rgb(190,54,235)',
                    'rgb(235,108,54)',
                    'rgb(235,199,54)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createMostCommonCommentComplainsChart(...values){
    let labels = [];
    let data = [];
    for (let i in values) {
        if (typeof values[i] === 'string'){
            labels.push(values[i])
        } else if (typeof values[i] === 'number'){
            data.push(values[i])
        }
    }

    let ctx = document.getElementById('mostCommonCommentComplainsChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Motivos de denúncia de comentário',
                data: data,
                backgroundColor: [
                    'rgba(128,255,99,0.2)',
                    'rgba(99,255,250,0.2)',
                    'rgba(190,54,235,0.2)',
                    'rgba(235,108,54,0.2)',
                    'rgba(235,199,54,0.2)'
                ],
                borderColor: [
                    'rgb(115,255,99)',
                    'rgb(99,255,250)',
                    'rgb(190,54,235)',
                    'rgb(235,108,54)',
                    'rgb(235,199,54)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createContactsChart(qnt1, qnt2, qnt3, qnt4, qnt5, qnt6){
    let ctx = document.getElementById('contactsChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Elogios', 'Sugestões', 'Reclamações', 'Problemas/bugs', 'contestação de ban', 'Outros motivos'],
            datasets: [{
                label: 'Motivos de contato',
                data: [qnt1, qnt2, qnt3, qnt4, qnt5, qnt6],
                backgroundColor: [
                    'rgba(128,255,99,0.2)',
                    'rgba(99,255,250,0.2)',
                    'rgba(235,54,54,0.2)',
                    'rgba(235,54,226,0.2)',
                    'rgba(84,84,84,0.2)'
                ],
                borderColor: [
                    'rgb(115,255,99)',
                    'rgb(99,255,250)',
                    'rgb(235,54,54)',
                    'rgb(235,54,226)',
                    'rgb(84,84,84)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}