


let novaReceitaModalElement = document.getElementById('novaReceitaModal')
let novaReceitaModal = new bootstrap.Modal(novaReceitaModalElement)



$(function () {

    novaReceitaModalElement.addEventListener('shown.bs.modal', function (e) {
        new Request('financeiro/categorias/listar', {
            provedor: provedorID,
            filters: { tipo: 'R' },
            params: {
                order_by: 'nome',
                sort_order: 'asc'
            }
        })
        .get(async response => {
            if (response.success === true) {
                let categorias = await response.categorias
                fillSelectReceitasCategoria(categorias)
            }
        })
    })

    novaReceitaModalElement.addEventListener('hidden.bs.modal', function (e) {
        resetSelectReceitasCategoria()
    })

    let option = $('#selectPeriodo').children(`option[value="${ window.APP.date().currentMonth() }"]`)
        option.attr('selected', true)

    loadReceitasIXC()
})



let loadReceitasIXC = function () {

    let selectPeriodo = document.getElementById('selectPeriodo')
    let periodo = selectPeriodo.options[selectPeriodo.selectedIndex].value

    new Request(`financeiro/receitas/ixc/baixadas/${ periodo }`)
        .before(resetReceitasIXC)
        .after(() => { $('span[id*="receitas-"].wrap-loader').removeClass('loading') })
        .get(async response => {
            let receitas = await response.receitas
            loadCardReceitas(receitas)
        })
}



let resetReceitasIXC = function () {
    $('span[id*="receitas-"].wrap-loader').addClass('loading')
    $('#receitas-recebidas-titulo').empty()
    $('#receitas-recebidas').empty()
    $('#receitas-areceber').empty()
}



let resetSelectReceitasCategoria = function () {
    $('#receita-categoria').empty()
    $(`<option value="0">Selecionar</option>`).appendTo($('#receita-categoria'))
}



let fillSelectReceitasCategoria = function(categorias) {
    let option = null

    resetSelectReceitasCategoria()

    categorias.forEach(categoria => {
        option = new Option(categoria.id).render(categoria.nome)
        $(option).appendTo($('#receita-categoria')) 
    })
}



let checkReceitas = function (receitas) {
    return receitas.abertas && receitas.agendadas && receitas.recebidas
}



let checkDespesas = function (despesas) {
    return despesas.abertas && despesas.agendadas && despesas.pagas
}



let loadPeriodo = function () {

    let selectPeriodo = document.getElementById('selectPeriodo')
    let periodo = selectPeriodo.options[selectPeriodo.selectedIndex].value

    let receitas = []
    let despesas = []

    new Request(`financeiro/receitas/listar/${ periodo }`)
        .get(response => {
            receitas = response.receitas
            
            if (checkReceitas(receitas)) {
                loadCardReceitas(receitas)

                if (checkDespesas(despesas)) {
                    loadCardResumo(receitas, despesas)
                }
            }

            $('span[id*="receitas-"] > .wrap-loader').removeClass('loading')
        })
    
    new Request(`financeiro/despesas/listar/${ periodo }`)
        .get(response => {
            despesas = response.despesas

            if (checkDespesas(despesas)) {
                loadCardDespesas(despesas)

                if (checkReceitas(receitas)) {
                    loadCardResumo(receitas, despesas)
                }
            }
        })
}



let loadCardReceitas = function (receitas) {

    let totalRecebido = 0
    let totalAreceber = 0

    if (receitas.recebidas && receitas.recebidas.length > 0) {
        for (let i = 0; i < receitas.recebidas.length; i++) {
            totalRecebido += parseFloat(receitas.recebidas[i].valor_recebido)
        }
    }

    if (receitas.areceber && receitas.areceber.length > 0) {
        for (let i = 0; i < receitas.areceber.length; i++) {
            totalAreceber += parseFloat(receitas.areceber[i].valor)
        }
    }

    $('span[id="receitas-recebidas-titulo"]').text('Receitas')
    $('span[id="receitas-recebidas"]').text(mask(totalRecebido).money())
    $('span[id="receitas-areceber"]').text(`A receber: ${ mask(totalAreceber).money() }`)
}



let loadCardDespesas = function (despesas) {

    let totalDespesasPagas = 0
    let totalDespesasAgendadas = 0

    if (despesas.pagas.length > 0) {
        totalDespesasPagas = despesas.pagas.reduce((acc, a) => (
            acc + a.valor
        ))
    }

    if (despesas.agendadas.length > 0) {
        totalDespesasAgendadas = despesas.agendadas.reduce((acc, a) => (
            acc + a.valor
        ))
    }

    $('span[id="despesas-pagas"]').text(mask(totalDespesasPagas).money())
    $('span[id="despesas-agendadas"]').text(`A pagar: ${ mask(totalDespesasAgendadas).money() }`)
}



let loadCardResumo = function (receitas, despesas) {

    let totalReceitasRecebidas = 0
    let totalReceitasAgendadas = 0

    let totalDespesasPagas = 0
    let totalDespesasAgendadas = 0

    if (receitas.recebidas.length > 0) {
        totalReceitasRecebidas = receitas.recebidas.reduce((acc, a) => (acc + a.valor))
    }

    if (receitas.agendadas.length > 0) {
        totalReceitasAgendadas = receitas.agendadas.reduce((acc, a) => (acc + a.valor))
    }

    if (despesas.pagas.length > 0) {
        totalDespesasPagas = despesas.pagas.reduce((acc, a) => (acc + a.valor))
    }

    if (despesas.agendadas.length > 0) {
        totalDespesasAgendadas = despesas.agendadas.reduce((acc, a) => (acc + a.valor))
    }

    let saldoReal = totalReceitasRecebidas - totalDespesasPagas
    let saldoPrevisto = ((totalReceitasRecebidas + totalReceitasAgendadas) - (totalDespesasPagas + totalDespesasAgendadas))

    $('span[id="saldo"]').text(mask(saldoReal).money())
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