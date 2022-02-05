


class Request {


    constructor (url, data = false) {

        this.url = `http://127.0.0.1:8000/${ url }`
        this.data = data

        this.beforeCallback = false
        this.afterCallback = false

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
    }


    before (callback) {
        this.beforeCallback = callback
        return this
    }


    after (callback) {
        this.afterCallback = callback
        return this
    }


    get (callback) {

        if (this.beforeCallback != false)
            this.beforeCallback.call(this)

        $.ajax(
            (this.data != false) ? {
                method: "GET",
                url: this.url,
                data: this.data
            } : {
                method: "GET",
                url: this.url
            }
        )
        .done(async response => {
            callback.call(this, await response)

            if (this.afterCallback != false)
                this.afterCallback.call(this)
        })
    }


    post (callback) {

        if (this.beforeCallback != false)
            this.beforeCallback.call(this)

        $.ajax({
            type: 'POST',
            url: this.url,
            data: this.data
        })
        .done(async response => {
            callback.call(this, await response)

            if (this.afterCallback != false)
                this.afterCallback.call(this)
        })
    }
}