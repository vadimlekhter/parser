$(document).ready(function () {
    let specialization_div = $('[data-qa="specialization-div"]');
    let specialization_body = $('.specialization-body');

    specialization_div.click(function () {
        if ($(this).is(':checked')) {
            specialization_body.show();
        } else {
            specialization_body.hide();
        }
    });
});
