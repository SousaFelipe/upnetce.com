


class Option {


    constructor (value) {
        this.value = value
    }


    render (text) {
        return (`<option value="${ this.value }">${ text }</option>`)
    }
}