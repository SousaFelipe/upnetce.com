


class Table {


    constructor (id, pageSize = 10) {

        this.id = id
        this.pageSize = pageSize

        this.table = $(`table[id="${ this.id }"]`)
        this.tbody = this.table.children('tbody')
        this.control = $(`div[data-table="${ this.id }"]`)

        this.dataset = {
            size: 0,
            rows: []
        }
    }


    size (size = false) {

        if (size) {
            this.dataset.size = size
            return this
        }

        return this.dataset.size
    }


    add (row = []) {
        this.dataset.rows.push(row)
        return this
    }


    draw (after = false) {
        this.after = after

        let pageRows = []
        let rounds = 0

        for (let i = 0; i < this.dataset.rows.length - 1; i = i + (this.pageSize - 1)) {
            pageRows.push(this.dataset.rows.slice(i + rounds, i + this.pageSize + rounds))
            rounds++
        }

        this.dataset.rows = pageRows

        this.drawControls()
        this.drawPage(0)

        return this
    }


    drawControls () {
        this.control.empty()

        let self = this

        for (let i = 1; i <= Math.ceil(this.dataset.size / this.pageSize); i++) {

            let num = (i > 9) ? i : `0${ i }`
            let id = `${ this.id }-pg_${ num }`

            this.control.append(`
                <input type="radio" class="btn-check" name="options-table-${ this.id }" id="${ id }" autocomplete="off" ${ i == 1 ? 'checked' : '' }>
                <label class="btn btn-sm btn-outline-primary" for="${ id }">${ num }</label>
            `)

            $(`label[for="${ id }"]`).on('click', function (e) {
                self.drawPage(i - 1)
            })
        }
    }


    drawPage (page) {
        this.tbody.empty()

        let currentPage = this.dataset.rows[page]

        for (let p = 0; p < currentPage.length; p++) {

            let currentData = currentPage[p]
            let row = `<tr>`

            for (let d = 0; d < currentData.length; d++) {
                row += currentData[d]
            }

            this.tbody.append(`${ row }</tr>`)
        }

        if (this.after)
            this.after.call(this)
    }


    static action (content) {
        return `<td class="pe-3">${ content }</td>`
    }


    static td(content) {
        return `<td class="text-secondary ps-3">${ content }</td>`
    }
}