

class Row {


    classes (inlineClasses) {
        this.inlineClasses = inlineClasses
        return this
    }


    render (children) {
        return (`
            <div class="row ${ this.inlineClasses }">
                ${ children }
            </div>
        `)
    }
}