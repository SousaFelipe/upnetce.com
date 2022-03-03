


class Alert {


    constructor (id, timeout = 0) {

        this.timeout = timeout
        this.container = document.querySelectorAll(`[data-alert-container-to='${ id }']`)[0]
        this.alert = document.getElementById(id)
        this.alertBody = document.getElementById(`${ id }Body`)

        this.bindAction(id)
    }


    bindAction (id) {
        let btnClose = document.querySelectorAll(`[data-alert-close='${ id }']`)[0]
        if (btnClose) {
            btnClose.addEventListener("click", () => this.hide())
        }
    }


    type (alertType) {
        $(this.alert).addClass(alertType)
        return this
    }


    hide () {
        let alertBody = this.alertBody

        $(this.alert).fadeOut('fast', function () {
            $(this).css('display', 'none')
            $(alertBody).empty()
        })
    }


    display (msg) {
        let self = this
        
        $(this.alertBody).empty()
        $(this.alertBody).append(msg)

        $(this.alert).fadeIn('fast', function() {
            $(this).css('display', 'flex')
        })

        if (this.timeout > 0) {
            setTimeout(() => { self.hide() }, this.timeout * 1000)
        }
    }
}