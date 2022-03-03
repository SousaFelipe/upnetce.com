


let fornecedorAlert = new Alert('fornecedorAlert', 3)
let fornecedoresTable = new Table('fornecedores')
let radioGroupTipoPessoa = new RadioGroup('btn-group-fornecedor-tipo_pessoa')



$(function () {

    new Request('cadastros/fornecedores/listar')
        .get(response => {
            if (response.success) {
                let fornecedores = response.fornecedores

                fornecedores.sort(function (a, b) {
                    return (a.habilitado == b.habilitado) ? 0 : a.habilitado == 'S' ? -1 : 1
                })

                fornecedoresTable.size(fornecedores.length)

                drawFornecedoresTable(fornecedores)
            }
        })
    
    radioGroupTipoPessoa.onChange(value => {
        $('span[id="label-cnpj_cpf"]').text((value == 'F') ? 'CPF' : 'CNPJ')
        $('input[id="fornecedor-cnpj_cpf"]').mask((value == 'F') ? '000.000.000-00' : '00.000.000/0000-00', { reverse: true })
    })
})



let drawFornecedoresTable = function (fornecedores) {
    
    let ixc  = 0
    let hblt = false
    let sync = false

    fornecedores.forEach(fornecedor => {

        ixc = fornecedor.id_ixc
        hblt = (fornecedor.habilitado == 'S')
        sync = Contract.sync(fornecedor)

        fornecedoresTable.add([

            Table.td(`<input type="checkbox" id="fornecedor-habilitado" class="form-check-input" data-check="${ ixc }" onclick="habDesabFornecedor(this)" ${ hblt ? 'checked' : '' }>`),
            Table.td(ixc),
            Table.td(fornecedor.titulo),

            Table.action(
                `<div class="d-flex flex-row justify-content-end align-items-center">
                    <span class="badge badge-sm bg-light text-${ sync ? 'white' : 'primary clickable' }" data-sync="${ ixc }" ${ sync ? '' : `onclick="syncFornecedor(this)"` }>
                        <i data-feather="refresh-ccw"></i>
                    </span>
                    <span class="badge badge-sm bg-light text-primary clickable ms-1" onclick="">
                        <i data-feather="edit"></i>
                    </span>
                    <span class="badge badge-sm bg-light text-primary clickable ms-1" onclick="">
                        <i data-feather="trash"></i>
                    </span>
                </div>`
            )
        ])
    })

    fornecedoresTable.draw(() => { feather.replace({ 'aria-hidden': 'true' }) })
}



let syncFornecedor = function (target) {
    new Request('cadastros/fornecedores/sync', {
        id_fornecedor: $(target).attr('data-sync')
    })
    .put(response => {

        let alert = {
            type: 'success',
            msg: 'Registro sincronizado com sucesso!'
        }

        if (response.success) {

            $(target).removeClass('text-primary')
            $(target).removeClass('clickable')
            $(target).addClass('text-white')
            $(target).addClass('bg-default')

            $(target).unbind()

        }
        else {
            alert.type = 'danger'
            alert.msg = 'Ocorreu um erro ao sincroniar o registro!'
        }

        fornecedorAlert.type(alert.type).display(alert.msg)
    })
}



let habDesabFornecedor = function (target) {

    new Request('cadastros/fornecedores/editar', {
            id_fornecedor: $(target).attr('data-check'),
            habilitado: $(target).is(':checked') ? 'S' : 'N'
        })
        .put(response => {
            if ( ! response.success) {
                alert('Ocorreu um erro ao atualizar o registro!')
            }
        })
}
