


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
    $('#despesa-valor').mask('#.##0,00', { reverse: true })



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
                    finderDespesaCategoria.option(categoria.id_ixc, categoria.nome)
                })
            })

        new Request('cadastros/fornecedores/listar', { habilitado: 'S' })
            .before(() => finderDespesaFornecedor.reset())
            .get(response => {
                response.fornecedores.forEach(fornecedor => {
                    finderDespesaFornecedor.option(fornecedor.id_ixc, fornecedor.titulo)
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

    console.log(remotas)

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

    let ctx = document.getElementById('balanceChart').getContext('2d')

    let data = {
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
            lineTension: 0.5,
            backgroundColor: 'transparent',
            borderColor: '#5C60F5',
            borderWidth: 4,
            pointBackgroundColor: '#4648b8'
        }]
    }
    
    new Chart(ctx, {
      
        type: 'line',

        data: data,

        options: {
            scales: {
                yAxes: [{
                    color: '#FFFFFF',
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    })
}



let salvarDespesa = function () {
 
    let categoria = finderDespesaCategoria.current()
    let fornecedor = finderDespesaFornecedor.current()
    let conta_caixa = finderDespesaConta.current()
    let valor = $('input[id="despesa-valor"]').val()

    if (categoria <= 0 || categoria == '') {
        alert('Selecione a categoria!')
    }
    else if (fornecedor <= 0 || fornecedor == '') {
        alert('Selecione um Fornecedor!')
    }
    else if (conta_caixa <= 0 || conta_caixa == '') {
        alert('Selecione uma Conta/Caixa!')
    }
    else if (valor == null || valor == '' || valor == '0,00') {
        alert('Por favor, insira o valor!')
    }
    else {
        new Request('financeiro/despesas/criar', {
            categoria:          categoria,
            codigo_barras:      $('input[id="despesa-codigo"]').val(),
            conta_caixa:        conta_caixa,
            data_emissao:       $('input[id="despesa-emissao"]').val(),
            data_vencimento:    $('input[id="despesa-vencimento"]').val(),
            documento:          $('input[id="despesa-documento"]').val(),
            id_fornecedor:      fornecedor,
            obs:                $('input[id="despesa-obs"]').val(),
            previsao:           new RadioGroup('btn-group-previsao').currentValue(),
            tipo_pagamento:     new RadioGroup('btn-group-tipo_pagamento').currentValue(),
            valor:              valor
        })
        .post(response => {
            if (response.success) {
                loadDashboardByPeriod()
                novaDespesaModal.close()
            }
        })
    }
}