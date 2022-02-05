


class Collapse {


    constructor (id) {
        this.id = id
        this.childrenElement = ''
    }


    isActive () {
        let slpHref = window.location.href.split('/')
        let lowedID = this.id.replaceAll(' ', '_').toLowerCase()

        if (slpHref.length == 7) {
            return decodeURI(slpHref[6]) == lowedID
        }
        else if (slpHref.length == 9) {
            return decodeURI(slpHref[6]) == lowedID || decodeURI(slpHref[8]) == lowedID
        }

        return false
    }


    children (childrenElement) {
        this.childrenElement = childrenElement
        return this
    }


    render () {
        return (`
            <div id="${ this.id }" class="collapse ${ this.isActive() ? 'show' : '' }">
                <div class="card card-body ps-0 pt-0 pb-0 pe-0">
                
                    ${ this.childrenElement }

                </div>
            </div>
        `)
    }
}