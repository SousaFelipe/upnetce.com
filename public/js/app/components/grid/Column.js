


class Column {


    constructor (size = 'auto') {
        this.size = size
    }


    classes (inlineClasses) {
        this.inlineClasses = inlineClasses
        return this
    }


    render (children) {
        return (`
            <div class="col-${ this.size } ${ this.inlineClasses }">
                ${ children }
            </div>
        `)
    }
}