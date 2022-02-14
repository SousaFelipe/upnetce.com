


class Contrato {


    constructor (contrato) {
        this.id = contrato.id
        this.id_vd_contrato = contrato.id_vd_contrato
        this.plano = contrato.plano
        this.status = contrato.status
        this.status_internet = contrato.status_internet
    }


    list (contratos) {
        let contratoList = new Array(contratos.length || 0)

        contratos.forEach(contrato => {
            contratoList.push(new Contrato(contrato))
        })

        this.contratoList = contratoList
    }


    acesso () {
        return this.status_internet == 'A'
    }


    bloqueado () {
        return this.status_internet == 'CA'
    }
}