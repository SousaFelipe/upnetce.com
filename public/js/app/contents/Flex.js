


class Flex {


    constructor (type = 'row', justify = 'start', align = 'start') {

        this.type = `flex-${ type}`
        this.justify = `justify-content-${ justify }`
        this.align = `align-items-${ align }`

        this.inlineClasses = `${ this.type } ${ this.justify } ${ this.align }`
    }


    classes (inlineClasses) {
        this.inlineClasses = (' ' + inlineClasses)
        return this
    }


    render (children) {
        return (`
            <div class="d-flex ${ this.inlineClasses }">
                ${ children }
            </div>
        `)
    }
}