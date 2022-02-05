


class Card {


    constructor (id) {
        this.id = id
    }


    classes (inlineClasses) {
        this.inlineClasses = inlineClasses
        return this
    }


    render (children) {

        return (`
            <div id="card-${ this.id }" class="card ${ this.inlineClasses }">
                <div id="card-body-${ this.id }" class="card-body">
                    <div id="card-body-alerts-${ this.id }" class="card-alerts"></div>
                    ${ children }
                </div>
            </div>
        `)
    }
}
