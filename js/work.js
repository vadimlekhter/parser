$(document).ready(function () {
    $.ajaxSetup({
        headers: {"Origin": "*"}
    });


    let work_input = $('#work-input');
    let work = $('#work');
    let work_div = $('.work-div');



    work_input.keypress(function () {
        let chars = work_input.val();
        $.getJSON('https://cors-anywhere.herokuapp.com/https://hh.ru/autosuggest/multiprefix/v2?q=' + chars + '&d=countries_RU', function (data) {
            let array = [];
            $.each(data, function () {
                $('.work-list').empty();
                $.each(data.items, function (val, key) {
                    array.push('<p class="work-item" data-id="' + key.id + '">' + key.text + '</p>');
                })
            });

            $('<ul/>', {
                'class': 'work-list',
                html: array.join('')
            }).appendTo(work_div);
        });
    });

    $(function () {
        $(document).on('click', '.work-item', function () {
            let work_name = $(this).html();
            let work_value = $(this).attr('data-id');
            work_input.val(work_name);
            work.val(work_value);
            $('.work-list').empty();
        });
    });

});