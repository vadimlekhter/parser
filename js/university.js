$(document).ready(function () {
    $.ajaxSetup({
        headers: {"Origin": "*"}
    });

    let university_div = $('.university-div');
    let university_input = $('#university-input');
    let university = $('#university');

    university_input.keypress(function () {
        let chars = university_input.val();
        $.getJSON('https://cors-anywhere.herokuapp.com/https://hh.ru/autosuggest/multiprefix/v2?q=' + chars + '&d=university_RU', function (data) {
            let array = [];
            $.each(data, function () {
                $('.university-list').empty();
                $.each(data.items, function (val, key) {
                    array.push('<p class="university-item" data-id="' + key.id + '">' + key.text + '</p>');
                })
            });

            $('<ul/>', {
                'class': 'university-list',
                html: array.join('')
            }).appendTo(university_div);
        });
    });

    $(function () {
        $(document).on('click', '.university-item', function () {
            let university_name = $(this).html();
            let university_value = $(this).attr('data-id');
            university_input.val(university_name);
            university.val(university_value);
            $('.university-list').empty();
        });
    });

});