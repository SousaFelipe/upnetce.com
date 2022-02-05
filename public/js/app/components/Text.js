


class Text {


    constructor (size, element = 'span') {
        this.size = size
        this.element = element
        this.inlineClasses = ''
    }


    classes (inlineClasses) {
        this.inlineClasses = inlineClasses
        return this
    }


    render (children) {
        return (`
            <${ this.element } class="fs-${ this.size } ${ this.inlineClasses }">
                ${ children }
            </${ this.element }>
        `)
    }
}