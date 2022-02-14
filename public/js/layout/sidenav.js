


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
        filters: { tipo: 'D' },
        params: {
            order_by: 'nome',
            sort_order: 'asc'
        }
    })
    .get(response => {
        if (response.success === true) {
            categorias = response.categorias

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



let salvarCategoria = function () {

    let categoria = $('#sob-categoria').find(":selected").val()
    let tipo = $('#tipo-categoria').find(":selected").val()
    let fixa = $('#categoria-fixa').is(':checked')
    let nome = $('#titulo-categoria').val()
    let id_ixc = $('#idixc-categoria').val()

    if (tipo == 0 || tipo == '0') {
        $('#tipo-categoria').trigger("focus")
        alert('Por favor, informe se a categoria é do tipo Receita ou Despesa!')
    }
    else if (nome == null || nome.length <= 0 || nome == '') {
        $('#titulo-categoria').trigger("focus")
        alert('Por favor, insira o nome da categoria!')
    }
    else {
    
        new Request('financeiro/categorias/criar', {
                id_ixc: id_ixc,
                categoria: categoria,
                nome: nome,
                tipo: tipo,
                fixa: fixa
            })
            .post(response => {
                if (response.success === true) {
                    closeNovaCategoriaModal()
                }
                else {
                    alert('Ocorreu um erro ao salvar este registro!')
                }
            })
    }
}



let startSearchClientes = function (slug) {
    clearTimeout(searchTimeout)

    $('#search-result-items').empty()
    $('#navbar-search-close').css({ 'display': 'block' })
    $('#search-container').css({ 'display': 'flex' })

    searchTimeout = setTimeout(() => {

        new Request(`cadastros/clientes/listar/${ slug }`)
            .get(response => {

                let clienteCtt = null
                let renderedCliente = null

                response.clientes.forEach(cliente => {

                    clienteCtt = new Cliente(cliente)
                    renderedCliente = getRenderedClienteData(clienteCtt)

                    $(new Card(cliente.id).classes('text-dark bg-light ms-4 me-4 mt-2 mb-1').render(renderedCliente))
                        .appendTo($('#search-result-items'))

                    if (clienteCtt.osPendente()) {
                        $(`<span class="badge rounded-pill bg-info ms-1"><i data-feather="tool"></i></span>`)
                            .appendTo($(`#card-body-alerts-${ cliente.id }`))
                    }

                    if (cliente.alerta != '') {
                        $(`<span class="badge rounded-pill bg-warning ms-1"><i data-feather="message-circle"></i></span>`)
                            .appendTo($(`#card-body-alerts-${ cliente.id }`))
                    }

                    if (clienteCtt.bloqueado()) {
                        $(`<span class="badge rounded-pill bg-danger ms-1"><i data-feather="lock"></i></span>`)
                            .appendTo($(`#card-body-alerts-${ cliente.id }`))
                    }
                })
                
                feather.replace({ 'aria-hidden': 'true' })
            })
        
    }, 1000)
}


let stopSearchClientes = function () {
    
    $('#navbar-search-close').css({ 'display': 'none' })
    $('#search-container').css({ 'display': 'none' })

    clearInterval(searchTimeout)
    searchTimeout = null
}



let closeSearch = function () {
    searchControlElement.value = ''
    $('#search-result-items').empty()
    $('#navbar-search-close').css({ 'display': 'none' })
    $('#search-container').css({ 'display': 'none' })
}


let closeNovaCategoriaModal = function () {

    $('#sob-categoria').val(0).change()
    $('#tipo-categoria').val(0).change()
    $('#titulo-categoria').val('')

    categoriasModal.previousModal = null
    categoriasModal.hide()
}



let getRenderedClienteData = function (cliente) {

    let razao = new Text('3').render(cliente.razao)
    let cpf = new Text('2').render(cliente.cnpj_cpf)
    let endereco = new Text('3').render(cliente.endereco)
    let complemento = new Text('2').render(cliente.complemento)
    let cell = new Text('2').render(cliente.telefone_celular)
    let whats = new Text('2').render(cliente.whatsapp)
    
    let col1 = new Column('1')
        .classes('d-flex flex-row justify-content-center align-items-center pe-0')
        .render(new Circle('md', cliente.ativo('color')).render(cliente.ativo('icon')))

    let col2 = new Column('4').classes('d-flex flex-column').render(razao + cpf)
    let col3 = new Column('4').classes('d-flex flex-column').render(endereco + complemento)
    let col4 = new Column('3').classes('d-flex flex-column').render(cell + whats)
    
    return new Flex('row')
        .render(new Row().classes('d-flex flex-row align-items-center flex-grow-1').render(col1 + col2 + col3 + col4))
}



let logout = function () {
    window.APP.form('logOutForm').submit()
}
