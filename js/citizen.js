$(document).ready(function () {
    $.ajaxSetup({
        headers: {"Origin": "*"}
    });


    let citizen_input = $('#citizen-input');
    let citizen = $('#citizen');
    let citizen_div = $('.citizen-div');



    citizen_input.keypress(function () {
        let chars = citizen_input.val();
        $.getJSON('https://cors-anywhere.herokuapp.com/https://hh.ru/autosuggest/multiprefix/v2?q=' + chars + '&d=countries_RU', function (data) {
            let array = [];
            $.each(data, function () {
                $('.citizen-list').empty();
                $.each(data.items, function (val, key) {
                    array.push('<p class="citizen-item" data-id="' + key.id + '">' + key.text + '</p>');
                })
            });

            $('<ul/>', {
                'class': 'citizen-list',
                html: array.join('')
            }).appendTo(citizen_div);
        });
    });

    $(function () {
        $(document).on('click', '.citizen-item', function () {
            let citizen_name = $(this).html();
            let citizen_value = $(this).attr('data-id');
            citizen_input.val(citizen_name);
            citizen.val(citizen_value);
            $('.citizen-list').empty();
        });
    });

});