


class Contract {

    static sync (contract) {
        
        if (!contract.sincronizado_em)
            return false

        let dt_sync = new Date(contract.sincronizado_em)
        let dt_updt = new Date(contract.atualizado_em)

        return dt_sync > dt_updt
    }
}