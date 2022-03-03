


class Finder {


    constructor (id, defaultValue = false) {
        this.id = id

        this.element = $(`div[id="${ id }"].data-finder`)
        this.defaultValue = defaultValue

        this.inputID = this.element.children('input[data-finder="id"]')
        this.inputSelect = this.element.children('select[data-finder="select"]')
        this.btnClear = this.element.children('button[data-finder="clear"]')
        this.btnOpen = this.element.children('button[data-finder="open"]')

        this.loadInputAction()
        this.loadButtonActions()
    }


    loadInputAction () {

        let inputID = this.inputID
        let inputSelect = this.inputSelect

        this.inputID.on('change', function (e) {
            let value = $(this).val()

            if (value == '' || value.length == 0) {
                inputSelect.children(`option[value="0"]`).prop('selected', true)
            }
            else {
                inputSelect.children(`option[value="${ value }"]`).prop('selected', true)
            }
        })

        this.inputSelect.on('change', function (e) {
            let value = $(this).find(":selected").val()
            
            if (value == 0 || value == '0') {
                inputID.val('')
            }
            else {
                inputID.val(value)
            }
        })
    }


    loadButtonActions () {
        let self = this

        this.btnClear.on('click', function (e) {
            self.clear()
        })
    }


    clear () {
        this.inputID.val('')
        this.inputSelect.children(`option[value="0"]`).prop('selected', true)
        return this
    }


    reset () {
        this.clear()
        
        this.inputID.val('')
        this.inputSelect.empty()

        if (this.defaultValue) {
            $(`<option value="0">${ this.defaultValue }</option>`).appendTo(this.inputSelect)
        }

        return this
    }


    option (value, text) {
        $(`<option id="${ this.id }-${ value }" value="${ value }">${ text }</option>`).appendTo(this.inputSelect)
        return this
    }


    current () {
        let current = this.inputSelect.find(":selected")
        return current.val()
    }
}