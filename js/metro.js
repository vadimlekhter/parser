$(document).ready(function () {
    $.ajaxSetup({
        headers: {"Origin": "*"}
    });

    let metro_div = $('.metro-div');
    let metro_input = $('#metro-input');
    let metro = $('#metro');
    let city_id = 0;

    $('.moscow').click(function() {
        city_id = 1;
        if ($(this).is(':checked') && !$('.peterburg').is(':checked')) {
            metro_div.show();
        } else {
            metro_div.hide();
        }
    })

    $('.peterburg').click(function() {
        city_id = 2;
        if ($(this).is(':checked') && !$('.moscow').is(':checked')) {
            metro_div.show();
        } else {
            metro_div.hide();
        }
    })

    metro_input.keypress(function () {
        let chars = metro_input.val();
        $.getJSON('https://cors-anywhere.herokuapp.com/https://hh.ru/autosuggest/multiprefix/v2?q=' + chars + '&d=metro_RU_'+ city_id, function (data) {
            let array = [];
            $.each(data, function () {
                $('.metro-list').empty();
                $.each(data.items, function (val, key) {
                    array.push('<p class="metro-item" data-id="' + key.id + '">' + key.text + '</p>');
                })
            });

            $('<ul/>', {
                'class': 'metro-list',
                html: array.join('')
            }).appendTo(metro_div);
        });
    });

    $(function () {
        $(document).on('click', '.metro-item', function () {
            let station_name = $(this).html();
            let station_value = $(this).attr('data-id');
            metro_input.val(station_name);
            metro.val(station_value);
            $('.metro-list').empty();
        });
    });

});