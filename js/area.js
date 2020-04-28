$(document).ready(function () {
    let area_div = $('[data-qa="area-div"]');
    let area_body = $('.area-body');

    area_div.click(function () {
        if ($(this).is(':checked')) {
            area_body.show();
        } else {
            area_body.hide();
        }
    });
});