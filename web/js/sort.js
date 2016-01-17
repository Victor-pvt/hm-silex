/**
 * Created by victor on 17.01.16.
 */
$(document).ready(function () {
    $('.order-date').click(function () {
        var order = $(this).attr('data-order'),
            sort = $(this).attr('data-sort');
        var order_like = $('.order-like');
        order_like.attr('data-sort', '');
        order_like.removeClass('asc');
        order_like.removeClass('desc');
        if (sort == 'desc') {
            sort = 'asc';
            $(this).removeClass('desc');
            $(this).addClass('asc');
        } else {
            sort = 'desc';
            $(this).removeClass('asc');
            $(this).addClass('desc');
        }
        $(this).attr('data-sort', sort);
        goSite($(this));
    });
    $('.order-like').click(function () {
        var order = $(this).attr('data-order'),
            sort = $(this).attr('data-sort');
        var order_date = $('.order-date');
        order_date.attr('data-sort', '');
        order_date.removeClass('asc');
        order_date.removeClass('desc');

        if (sort == 'desc') {
            sort = 'asc';
            $(this).removeClass('desc');
            $(this).addClass('asc');
        } else {
            sort = 'desc';
            $(this).removeClass('asc');
            $(this).addClass('desc');
        }
        $(this).attr('data-sort', sort);
        goSite($(this));
    });

    $('.click-like').click(function () {
        goSite($(this));
        return false;
    });
    $('.click-show').click(function () {
        goSite($(this));
        return false;
    });

    function goSite(th) {
        var action = th.attr('data-action'),
            orderP = $('[data-order="publication_at"]').attr('data-order'),
            orderL = $('[data-order="like_count"]').attr('data-order'),
            sortP = $('[data-order="publication_at"]').attr('data-sort'),
            sortL = $('[data-order="like_count"]').attr('data-sort'),
            url = action + '?' + orderP + '=' + sortP + '&' +
                orderL + '=' + sortL;
        ;
        window.location.href = url;
    }


    $('.click-step').click(function () {
        var action = $(this).attr('data-action');
        var
            orderPA = $(this).attr('data-order-date').split('|'),
            orderLA = $(this).attr('data-order-like').split('|'),
            orderP = orderPA[0], orderL = orderLA[0],
            sortP = '',
            sortL = '';

        if (orderPA.length > 1) {
            sortP = orderPA[1];
        }
        if (orderLA.length > 1) {
            sortL = orderPA[1];
        }
        var
            url = action + '?' + orderP + '=' + sortP + '&' +
                orderL + '=' + sortL;
        window.location.href = url;
        return false;
    });


    /*

     var ss= $('.container.book-table');
     $.ajax({
     url: url,
     dataType: 'html',
     success: function (html) {
     ss.empty();
     ss.append(html);
     }
     });
     $('.order').click(function() {
     sort();
     });


     var order = $(this).attr('data-order'),
     sort = $(this).attr('data-sort');
     if(sort == 'asc'){
     sort = 'desc';
     $(this).removeClass('asc');
     $(this).addClass('desc');
     }else{
     sort = 'asc';
     $(this).removeClass('desc');
     $(this).addClass('asc');
     }
     $(this).attr('data-sort', sort);

     var action = $(this).attr('data-action'),
     orderP = $('[data-order="publication_at"]').attr('data-order'),
     orderL = $('[data-order="like_count"]').attr('data-order'),
     sortP = $('[data-order="publication_at"]').attr('data-sort'),
     sortL = $('[data-order="like_count"]').attr('data-sort'),
     url = action + '?' + orderP + '=' + sortP + '&' +
     orderL + '=' + sortL;
     ;

     var ss= $('.container.book-table');
     $.ajax({
     url: url,
     dataType: 'html',
     success: function (html) {
     ss.empty();
     ss.append(html);
     }
     });
     */
});

