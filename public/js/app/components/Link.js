


class Link {


    constructor(href) {
        this.href = `http://127.0.0.1:8000/${ href }`
        this.childrenElement = false
    }


    children(childrenElement, target = false) {
        this.childrenElement = childrenElement

        if (target) {
            this.href = `${ this.href }/${ this.childrenElement.replaceAll(' ', '_').toLowerCase() }`
        }

        return this
    }


    render () {
        return (`
            <a class="link" href=${ this.href }>${ this.childrenElement }</a>
        `)
    }
}