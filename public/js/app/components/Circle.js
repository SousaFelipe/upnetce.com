


class Circle {


    constructor (size = 'md', color = 'light') {
        this.size = size
        this.color = color
    }


    render (children) {
        return (`
            <div class="circle-${ this.size } bg-${ this.color }">
                ${ children }
            </div>
        `)
    }
}