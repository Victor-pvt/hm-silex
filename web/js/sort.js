/**
 * Created by victor on 17.01.16.
 */
$(document).ready(function () {

    $('.order').click(function() {
        var order = $(this).attr('data-order'),
            sort = $(this).attr('data-sort');
        if(sort == 'ASC'){
            sort = 'DESC'
        }else{
            sort = 'ASC'
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

        $.get(url);
    });
});

