


class Login {


    constructor (login) {
        this.id = login.id
        this.login = login.login
        this.online = login.online
        this.senha = login.senha
    }


    isOn () {
        return (this.online == 'SS')
    }
}