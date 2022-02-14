


$(document).on('dblclick', 'input[list]', function(event) {
    event.preventDefault()
    
    var str = $(this).val()

    $('div[list=' + $(this).attr('list') + '] span').each(function (k, obj) {
        if ($(this).html().toLowerCase().indexOf(str.toLowerCase()) < 0) {
            $(this).hide()
        }
    })

    $('div[list=' + $(this).attr('list') + ']').toggle(100)
    $(this).focus()
})



$(document).on('blur', 'input[list]', function (event) {
    event.preventDefault()

    var list = $(this).attr('list')

    setTimeout(function(){
        $('div[list=' + list + ']').hide(100)
    }, 100)
})



$(document).on('click', 'div[list] span', function (event) {
    event.preventDefault()

    var list = $(this).parent().attr('list')
    var item = $(this).html()

    $('input[list=' + list + ']').val(item)
    $('div[list=' + list + ']').hide(100)
})



$(document).on('keyup', 'input[list]', function (event) {
    event.preventDefault()
    
    var list = $(this).attr('list')
    var divList =  $('div[list=' + $(this).attr('list') + ']')

    if (event.which == 27) {
        $(divList).hide(200)
        $(this).focus()
    }
    else if (event.which == 13) {
        if ($('div[list=' + list + '] span:visible').length == 1) {
            var str = $('div[list=' + list + '] span:visible').html()

            $('input[list=' + list + ']').val(str)
            $('div[list=' + list + ']').hide(100)
        }
    }
    else if(event.which == 9) {
        $('div[list]').hide()
    }
    else {
        $('div[list='+list+']').show(100)

        var str  = $(this).val()

        $('div[list=' + $(this).attr('list') + '] span').each(function () {
            if ($(this).html().toLowerCase().indexOf(str.toLowerCase()) < 0) {
                $(this).hide(200)
            }
            else {
                $(this).show(200)
            }
        })
    }
})