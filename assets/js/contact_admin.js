$(function () {
    let toggleAnswered = $('.disabled-toggle');
    if (toggleAnswered.length > 0) {
        toggleAnswered.each(function () {
            $(this).find('input[type=checkbox]').attr('disabled', 'disabled');
        });
    }
});
