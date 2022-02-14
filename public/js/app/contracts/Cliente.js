


class Cliente {


    constructor (cliente) {
        this.alerta = cliente.alerta
        this.isAtivo = cliente.ativo
        this.bairro = cliente.bairro
        this.cep = cliente.cep
        this.cidade = cliente.cidade
        this.cnpj_cpf = cliente.cnpj_cpf
        this.complemento = cliente.complemento
        this.data_nascimento = cliente.data_nascimento
        this.endereco = cliente.endereco
        this.id = cliente.id
        this.ie_identidade = cliente.ie_identidade
        this.obs = cliente.obs
        this.ordens_de_servico = cliente.ordens_de_servico
        this.razao = cliente.razao
        this.telefone_celular = cliente.telefone_celular
        this.uf = cliente.uf
        this.whatsapp = cliente.whatsapp
        this.sexo = cliente.Sexo

        this.contratoList = new Array(cliente.contratos ? cliente.contratos.length : 0)
        this.loginList = new Array(cliente.logins ? cliente.logins.length : 0)

        this.contratos(cliente.contratos)
        this.logins(cliente.logins)
    }


    contratos (contratoList = false) {

        if (contratoList) {
            let contratos = []

            contratoList.forEach(contrato => {
                contratos.push(new Contrato(contrato))
            })

            this.contratoList = contratos
        }
        
        return this.contratoList
    }


    logins (loginList = false) {

        if (loginList) {
            let logins = []

            loginList.forEach(login => {
                logins.push(new Login(login))
            })

            this.loginList = logins
        }
        
        return this.loginList
    }


    ativo (result = 'boolean') {
        let isAtivo = (this.isAtivo === 'S')

        return (result === 'icon')
            ? `<span data-feather="${ isAtivo ? 'user' : 'x' }"></span>`
            : (result === 'color')
                ? isAtivo
                    ? 'green'
                    : 'gray'
                : isAtivo
    }


    bloqueado () {

        let bloqueados = (this.contratos() && this.contratos().length > 0)
            ? this.contratos().reduce((acc, a) => (acc + (a.bloqueado()) ? 1 : 0))
            : 0

        return (bloqueados > 0)
    }


    osPendente () {

        let ossEmAberto = this.ordens_de_servico.filter(os => (
            os.status == 'A'
        ))
        
        return (ossEmAberto.length > 0)
    }
}