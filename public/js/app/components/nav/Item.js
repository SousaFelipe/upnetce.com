

class Item {


    constructor (id, prefix = false) {

        if (typeof id == "string") {
            id = id.replaceAll(' ', '_').toLowerCase()
        }

        this.id = (prefix != false) ? (
            `${ prefix }-${ id }`
        ) : (
            id
        )

        this.childrenElement = false
        this.needControl = false
        this.controlElement = false
    }


    children (childrenElement) {
        this.childrenElement = childrenElement
        return this
    }


    control (controlElement) {
        this.controlElement = controlElement
        this.needControl = true
        return this
    }


    renderDataControls () {
        return (
            `data-bs-toggle="collapse"
             data-bs-target="#${ this.controlElement }"
             aria-expanded="true"
             aria-controls="${ this.controlElement }"`
        )
    }


    isActive () {
        let slpHref = window.location.href.split('/')

        if (slpHref.length == 7) {
            return decodeURI(slpHref[6]) == this.id
        }
        else if (slpHref.length == 9) {
            return decodeURI(slpHref[6]) == this.id || decodeURI(slpHref[8]) == this.id
        }

        return false
    }

    
    render (className = 'nav-item') {

        return (`
            <li
                id="${ this.id }"
                class="${ className } ${ this.isActive() ? 'active' : '' }"
                role="button"
                ${ this.needControl ? this.renderDataControls() : '' }>

                ${ this.childrenElement ? this.childrenElement : '' }

                ${ this.needControl ? `<span data-feather="chevron-right"></span>` : `` }

            </li>
        `)
    }
}