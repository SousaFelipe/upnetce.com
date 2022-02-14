


let novaReceitaModalElement = document.getElementById('novaReceitaModal')
let novaReceitaModal = new bootstrap.Modal(novaReceitaModalElement)

let novaDespesaModalElement = document.getElementById('novaDespesaModal')
let novaDespesaModal = new bootstrap.Modal(novaDespesaModalElement)

let finderDespesaCategoria = new Finder('finder-despesa-categoria', 'Categoria')
let finderDespesaFornecedor = new Finder('finder-despesa-fornecedor', 'Fornecedor')
let finderDespesaConta = new Finder('finder-despesa-conta_caixa', 'Conta/Caixa')

let receitasRemotasRecebidas = 0
let receitasRemotasAreceber = 0

let despesasRemotasPagas = 0
let despesasRemotasEmAberto = 0



$(function () {

    $('#selectPeriodo').children(`option[value="${ window.APP.date().currentMonth() }"]`).attr('selected', true)
    $('input[type="date"]').val( window.APP.date().today().split('/').reverse().join('-') )
    $('#despesa-valor').mask("#.##0,00", {reverse: true})



    novaReceitaModalElement.addEventListener('shown.bs.modal', function (e) {
        new Request('financeiro/categorias/listar', {
            provedor: provedorID,
            filters: { tipo: 'R' },
            params: {
                order_by: 'nome',
                sort_order: 'asc'
            }
        })
        .get(response => {
            if (response.success === true) {
                let categorias = response.categorias
                fillSelectReceitasCategoria(categorias)
            }
        })
    })

    novaDespesaModalElement.addEventListener('shown.bs.modal', function (e) {

        new Request('financeiro/categorias/listar')
            .before(() => finderDespesaCategoria.reset())
            .get(response => {
                response.categorias.forEach(categoria => {
                    finderDespesaCategoria.option(categoria.id, categoria.nome)
                })
            })

        new Request('cadastros/fornecedores/listar', { habilitado: 'S' })
            .before(() => finderDespesaFornecedor.reset())
            .get(response => {
                response.fornecedores.forEach(fornecedor => {
                    finderDespesaFornecedor.option(fornecedor.id, fornecedor.titulo)
                })
            })

        new Request('financeiro/contas/listar')
            .before(() => finderDespesaConta.reset())
            .get(response => {
                response.contas.forEach(conta => {
                    finderDespesaConta.option(conta.id, conta.conta)
                })
            })
    })

    loadDashboardByPeriod()
})



let loadDashboardByPeriod = function () {

    let selectPeriodo = document.getElementById('selectPeriodo')
    let periodo = selectPeriodo.options[selectPeriodo.selectedIndex].value

    new Request(`financeiro/receitas/listar`, { periodo: periodo })
        .before(() => {
            resetReceitas()
            resetDespesas()
            resetSaldo()
        })
        .after(() => {
            new Request(`financeiro/despesas/listar`, { periodo: periodo })
                .after(() => {
                    loadCardResumo()
                })
                .get(response => {
                    loadCardDespesas(response.despesas)
                })
        })
        .get(response => {
            loadCardReceitas(response.receitas)
        })

    loadBalance(periodo)
}



let resetReceitas = function () {
    $('span[id*="receitas-"].wrap-loader').addClass('loading')
    $('#receitas-recebidas-titulo').empty()
    $('#receitas-recebidas').empty()
    $('#receitas-areceber').empty()
}


let resetDespesas = function () {
    $('span[id*="despesas-"].wrap-loader').addClass('loading')
    $('#despesas-pagas-titulo').empty()
    $('#despesas-pagas').empty()
    $('#despesas-emaberto').empty()   
}


let resetSaldo = function () {
    $('span[id*="saldo-"].wrap-loader').addClass('loading')
    $('span[id="saldo-titulo"]').empty()
    $('span[id="saldo-atual"]').empty()
    $('span[id="saldo-previsto"]').empty()  
}



let loadCardReceitas = function (receitas) {
    $('span[id*="receitas-"].wrap-loader').removeClass('loading')

    let remotas = receitas.remote

    receitasRemotasRecebidas = 0
    receitasRemotasAreceber = 0

    if (remotas.recebidas && remotas.recebidas.length > 0) {
        for (let i = 0; i < remotas.recebidas.length; i++) {
            receitasRemotasRecebidas += parseFloat(remotas.recebidas[i].valor_recebido)
        }
    }

    if (remotas.areceber && remotas.areceber.length > 0) {
        for (let i = 0; i < remotas.areceber.length; i++) {
            receitasRemotasAreceber += parseFloat(remotas.areceber[i].valor)
        }
    }

    $('span[id="receitas-recebidas-titulo"]').text('Receitas')
    $('span[id="receitas-recebidas"]').text(mask(receitasRemotasRecebidas).money())
    $('span[id="receitas-areceber"]').text(`A receber: ${ mask(receitasRemotasAreceber).money() }`)
}


let loadCardDespesas = function (despesas) {
    $('span[id*="despesas-"].wrap-loader').removeClass('loading')

    let remotas = despesas.remote

    despesasRemotasPagas = 0
    despesasRemotasEmAberto = 0

    if (remotas.pagas.length > 0) {
        for (let i = 0; i < remotas.pagas.length; i++) {
            despesasRemotasPagas += parseFloat(remotas.pagas[i].valor_total_pago)
        }
    }

    if (remotas.em_aberto.length > 0) {
        for (let i = 0; i < remotas.em_aberto.length; i++) {
            despesasRemotasEmAberto += parseFloat(remotas.em_aberto[i].valor_aberto)
        }
    }

    $('span[id="despesas-pagas-titulo"]').text('Despesas')
    $('span[id="despesas-pagas"]').text(mask(despesasRemotasPagas).money())
    $('span[id="despesas-emaberto"]').text(`Em aberto: ${ mask(despesasRemotasEmAberto).money() }`)
}


let loadCardResumo = function () {
    $('span[id*="saldo-"].wrap-loader').removeClass('loading')

    let saldoAtual = (receitasRemotasRecebidas - despesasRemotasPagas)

    let saldoPrevisto = (
        (receitasRemotasRecebidas + receitasRemotasAreceber) - (despesasRemotasPagas + despesasRemotasEmAberto)
    )

    $('span[id="saldo-titulo"]').text('Saldo')
    $('span[id="saldo-atual"]').text(mask(saldoAtual).money())
    $('span[id="saldo-previsto"]').text(`Previsto: ${ mask(saldoPrevisto).money() }`)
}



let loadBalance = function (periodo) {
    var ctx = document.getElementById('balanceChart')
    
    new Chart(ctx, {
      
        type: 'line',

        data: {
            labels: [
                'SEG',
                'TER',
                'QUA',
                'QUI',
                'SEX',
                'SAB'
            ],
            datasets: [{
                data: [
                    3450,
                    2560,
                    3220,
                    6841,
                    2605,
                    1982
                ],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007BFF',
                borderWidth: 4,
                pointBackgroundColor: '#007BFF'
            }]
        },

        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    })
}



let modalNovaReceita = function () {

}



let modalNovaDespesa = function () {

}