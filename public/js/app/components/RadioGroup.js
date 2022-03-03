


class RadioGroup {


    constructor (id) {
        this.element = $(`#${ id }`)
        this.radios = this.element.children('input[type="radio"]')
    }


    onChange (callback) {

        this.radios.each(function () {
            $(this).on('click', function (e) {
                callback.call(this, $(this).attr('data-radio'))
            })
        })

        return this
    }


    currentValue () {
        let current = null

        this.radios.each(function () {
            let checked = $(this).attr('checked')

            if (checked === 'checked' || checked === true) {
                current = $(this).attr('data-radio')
            }
        })

        return current
    }
}