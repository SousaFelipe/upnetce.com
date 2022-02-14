


$('.alert').hide(() => {
    $('.alert-container').css('margin-top', 0)
})



$(document).ajaxStart(function () {
    Pace.restart()
})
.ajaxStop(function () {
    Pace.stop()
})
.ajaxError(function () {
    Pace.stop()
})
.ajaxComplete(function () {
    Pace.stop()
})



$(function () {
    if (window.APP == undefined) {

        window.APP = {

            form: (id) => {
                let element = document.getElementById(id)

                return {
                    submit: () => element.submit()
                }
            },

            component: (type, id) => {
                let element = document.getElementById(id)

                const components = {
                    'button':   () => buttonComponent(element),
                    'input':    () => inputComponent(element)
                }

                return (components[type])()
            },

            assets: (filename) => {
                let iconsURL = `${ config.webUri }/images/icons`

                return {
                    icon: (filetype = 'png') => (`${ iconsURL }/${ filename }.${ filetype }`)
                }
            },

            mask: (clean) => {
                return {
                    cell: () => clean.replace(/\D/g, '').replace(/^(\d{2})(\d{1})(\d{4})(\d{4})?/, '($1) $2 $3-$4'),
                    cep: () => clean.replace(/\D/g, '').replace(/^(\d{5})(\d{3})?/, '$1-$2'),
                    cnpj: (format = '$1.$2.$3/$4-$5') => clean.replace(/\D/g, '').replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, format),
                    date: (joiner = '/') => clean.split('-').reverse().join(joiner),
                    money: () => clean.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
                }
            },

            url: (level = false) => {
                return {

                    web: (endpoint) => (
                        level
                            ? `${ config.webUri }/${ level }/${ endpoint }`
                            : `${ config.webUri }/${ endpoint }`
                    ),

                    api: (endpoint) => (
                        level
                            ? `${ config.apiUri }/${ level }/${ endpoint }`
                            : `${ config.apiUri }/${ endpoint }`
                    )
                }
            },

            date: () => {

                const MONTHS = [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ]

                const now = new Date()

                return {
                    currentMonth: () => MONTHS[now.getMonth()],
                    today: () => now.toLocaleDateString(),
                    date: () => now
                }
            }
        }
    }
})



function buttonComponent (element) {
    return {
        disable: () => element.setAttribute('disabled', true),
        enable:  () => element.setAttribute('disabled', false)
    }
}



function inputComponent (element) {
    return {
        invalidate: () => {
            element.classList.add('is-invalid')
            element.addEventListener('change', function(e) {
                element.classList.remove('is-invalid')
                element.removeEventListener('change', e)
            })
        }
    }
}