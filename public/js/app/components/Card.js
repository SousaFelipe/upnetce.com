


class Card {


    classes (inlineClasses) {
        this.inlineClasses = inlineClasses
        return this
    }


    render (children) {

        return (`
            <div class="card ${ this.inlineClasses }">
                <div class="card-body pb-1">
                    ${ children }
                </div>
            </div>
        `)
    }
}