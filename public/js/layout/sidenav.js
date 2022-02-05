


let mask        = null
let categorias  = null
let provedorID  = null
let userID      = null

let categoriasModalElement = document.getElementById('categoriasModal')
let categoriasModal = new bootstrap.Modal(categoriasModalElement)
    categoriasModal.previousModal = null

let searchControlElement = document.getElementById('search-control')
let searchContainterElement = document.getElementById('search-container')
let searchTimeout = null



$(function () {
    mask = window.APP.mask

    provedorID = document.querySelector('meta[name="provedor-id"]').getAttribute('content')
    userID = document.querySelector('meta[name="user-id"]').getAttribute('content')

    categoriasModalElement.addEventListener('shown.bs.modal', function (e) {
        $('#titulo-categoria').trigger("focus")

        let previous = e.relatedTarget.getAttribute('data-bs-previous')

        if (previous) {
            let previousElement = document.getElementById(previous)
            categoriasModal.previousModal = new bootstrap.Modal(previousElement)
        }
    })

    categoriasModalElement.addEventListener('hidden.bs.modal', function (e) {
        if (categoriasModal.previousModal) {
            categoriasModal.previousModal.show()
            categoriasModal.previousModal = null
        }
    })

    searchControlElement.addEventListener('keyup', function (e) {
        let slug = e.target.value
        
        if (slug && slug.length >= 3) {
            startSearchClientes(slug)
        }
        else {
            stopSearchClientes()
        }
    })

    loadCategorias()
})



let resetSelectDespesasCategoria = function () {
    $('#sob-categoria').empty()
    $(`<option class="text-tertiary" value="0">Nenhuma...</option>`).appendTo($('#sob-categoria'))
}



let fillSelectDespesasCategoria = function(categorias) {
    let option = null

    resetSelectDespesasCategoria()

    categorias.forEach(categoria => {
        option = new Option(categoria.id).render(categoria.nome)
        $(option).appendTo($('#sob-categoria')) 
    })
}



let loadCategorias = function () {

    new Request('financeiro/categorias/listar', {
        provedor: provedorID,
        filters: { tipo: 'D' },
        params: {
            order_by: 'nome',
            sort_order: 'asc'
        }
    })
    .get(async response => {
        if (response.success === true) {
            categorias = await response.categorias

            if (categorias.length > 0) {

                fillSelectDespesasCategoria(categorias.filter(categoria => (categoria.categoria == 0)))
                fillNavCategorias(categorias)

                feather.replace({ 'aria-hidden': 'true' })
            }
        }
    })
}



let fillNavCategorias = function (categorias) {
    let childrens = []

    $('#categorias-nav-container').empty()

    categorias.forEach(categoria => {
        childrens = categorias.filter(cat => cat.categoria == categoria.id)
        
        if (childrens.length > 0) {
            renderCollapseNavCategoriaItem(categoria)
            renderCollapseMenuTo(categoria, childrens)
        }
        else if (categoria.categoria == 0) {
            renderNavCategoriaItem(categoria)
        }
    })

    $('.nav-cat-item').on("click", function (e) {
        
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
        }
        else {
            $('.nav-cat-item').removeClass('active')
            $(this).addClass('active')
        }
    })
}



let renderNavCategoriaItem = function (categoria) {

    let item = new Item(categoria.nome)
        .children(
            new Link(`financeiro/categorias/mostrar`)
                .children(categoria.nome, true)
                .render()
        )
        .render('nav-cat-item')

    $(item).appendTo($('#categorias-nav-container'))
}



let renderCollapseNavCategoriaItem = function (categoria) {

    let item = new Item(categoria.nome)
        .children(`<span class="link-text">${ categoria.nome }</span>`)
        .control(categoria.nome)
        .render('nav-cat-item')

    $(item).appendTo($('#categorias-nav-container'))
}



let renderCollapseMenuTo = function (categoria, childrens) {

    $(new Collapse(categoria.nome).render())
        .appendTo($('#categorias-nav-container'))

    let currentChild = null

    childrens.forEach(child => {

        currentChild = new Item(child.nome)
            .children(
                new Link(`financeiro/categorias/mostrar/${ categoria.nome.toLowerCase() }/subcategoria`)
                    .children(child.nome, true)
                    .render()
            )
            .render('nav-cat-child')

        $(currentChild).appendTo($(`#${ categoria.nome } > .card-body`))
    })
}



let renderCategoriaOption = function (categoria) {

    let option = new Option(categoria.id)
        .render(categoria.nome)

    $(option).appendTo($('#sob-categoria'))
}



let salvarCategoria = function (fechar = false) {

    let selectSob = $('#sob-categoria')
    let selectTipo = $('#tipo-categoria')
    let checkFixa = $('#categoria-fixa')
    let inputNome = $('#titulo-categoria')

    let tipo = selectTipo.find(":selected").val()
    let fixa = checkFixa.is(':checked')
    let nome = inputNome.val()

    if (tipo == 0 || tipo == '0') {
        $('#tipo-categoria').trigger("focus")
        alert('Por favor, informe se a categoria é do tipo Receita ou Despesa!')
    }
    else if (nome == null || nome.length <= 0 || nome == '') {
        $('#titulo-categoria').trigger("focus")
        alert('Por favor, insira o nome da categoria!')
    }
    else {

        let categoria = {
            provedor: provedorID,
            user: userID,
            categoria: selectSob.find(":selected").val(),
            nome: nome,
            tipo: tipo,
            fixa: fixa
        }
    
        new Request('financeiro/categorias/criar', categoria)
            .post(response => {
                if (response.success === true) {
                    
                    selectSob.val(0).change()
                    selectTipo.val(0).change()
                    inputNome.val('')
                
                    if (fechar) {
                        categoriasModal.hide()
                    }
                    else {
                        $('#titulo-categoria').focus()
                    }
                }
                else {
                    alert('Ocorreu um erro ao salvar este registro!')
                }
            })
    }
}



let startSearchClientes = function (slug) {

    $('#search-result-items').empty()
    searchContainterElement.style.display = 'flex'
    clearTimeout(searchTimeout)

    searchTimeout = setTimeout(() => {

        new Request(`cadastros/clientes/listar/${ slug }`)
            .get(response => {

                response.clientes.forEach(cliente => {

                    $(new Card(cliente.id).classes('text-dark bg-light ms-4 me-4 mt-2 mb-1').render(getRenderedClienteData(cliente)))
                        .appendTo($('#search-result-items'))

                    if (cliente.ordens_de_servico && cliente.ordens_de_servico.length > 0) {
                        $(`<span class="badge rounded-pill bg-info ms-1"><i data-feather="tool"></i></span>`)
                            .appendTo($(`#card-body-alerts-${ cliente.id }`))
                    }

                    if (cliente.alerta && cliente.alert != '') {
                        $(`<span class="badge rounded-pill bg-warning ms-1"><i data-feather="alert-triangle"></i></span>`)
                            .appendTo($(`#card-body-alerts-${ cliente.id }`))
                    }
                })
                
                feather.replace({ 'aria-hidden': 'true' })
            })
        
    }, 1000)
}



let stopSearchClientes = function (slug) {
    searchContainterElement.style.display = 'none'
    clearInterval(searchTimeout)
    searchTimeout = null
}



let closeSearch = function () {
    searchControlElement.value = ''
    $('#search-result-items').empty()
    searchContainterElement.style.display = 'none'
}



let getRenderedClienteData = function (cliente) {

    let razao = new Text('3').render(cliente.razao)
    let cpf = new Text('2').render(cliente.cnpj_cpf)
    let endereco = new Text('3').render(cliente.endereco)
    let complemento = new Text('2').render(cliente.complemento)
    let cell = new Text('2').render(cliente.telefone_celular)
    let whats = new Text('2').render(cliente.whatsapp)

    let ativo = cliente.ativo == 'S'
    
    let col1 = new Column('1')
        .classes('d-flex flex-row justify-content-center align-items-center pe-0')
        .render(new Circle('md', ativo ? 'green' : 'gray').render(`<span data-feather="${ ativo ? 'user' : 'x' }"></span>`))

    let col2 = new Column('4').classes('d-flex flex-column').render(razao + cpf)
    let col3 = new Column('4').classes('d-flex flex-column').render(endereco + complemento)
    let col4 = new Column('3').classes('d-flex flex-column').render(cell + whats)
    
    return new Flex('row')
        .render(new Row().classes('d-flex flex-row align-items-center flex-grow-1').render(col1 + col2 + col3 + col4))
}



let getRenderedLoginContrato = function (logins, contratos) {
        
    let ativos = contratos && contratos.length > 0
        ? contratos.reduce((acc, a) => (acc + (a.status == 'A') ? 1 : 0))
        : 0
    
    if (contratos && contratos.length > 0 && ativos > 0) {

        let bloqueados = contratos && contratos.reduce((acc, a) => (acc + (a.status_internet == 'CA') ? 1 : 0))

        let iconLogin = (logins[0].online == 'S') ? 'rss' : 'slash'
        let colorLogin = (logins[0].online == 'S') ? 'green' : 'orange'

        let iconCtt = (bloqueados > 0) ? 'lock' : (ativos > 0) ? 'check-circle' : 'x'
        let colorCtt = (bloqueados > 0) ? 'danger' : (ativos > 0) ? 'success' : 'gray'

        return (`
            <div class="d-flex flex-row">
                <div class="row d-flex flex-row align-items-center flex-grow-1 mt-2 pt-1 pb-1">
                    <div class="col-1"></div>
                    <div class="col-4 d-flex flex-row align-items-center">
                        <span class="circle-xs bg-white">
                            <i data-feather="${ iconLogin }" class="text-${ colorLogin }"></i>
                        </span>
                        <span class="fs-2 ms-2">${ logins[0].login }</span>
                    </div>
                    <div class="col-4 d-flex flex-row align-items-center">
                        <span class="circle-xs bg-${ colorCtt }">
                            <i data-feather="${ iconCtt }"></i>
                        </span>
                        <span class="fs-2 ms-2">30MB POR R$60,00 (FIBRA LIGHT)</span>
                    </div>
                </div>
            </div>
        `)
    }
    
    return ''
}



let logout = function () {
    window.APP.form('logOutForm').submit()
}
