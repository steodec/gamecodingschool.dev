function isEmail(email) {
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

$(function () {
    $(document).on('keyup', 'input[type="email"]', function () {
        if (isEmail($(this).val())) {
            $($($(this).parent()).parent()).last().find("input:last").prop("disabled", false)
            $(this).attr("class", 'input-success');
        } else {
            $($($(this).parent()).parent()).last().find("input:last").prop("disabled", true)
            $(this).attr("class", 'input-error');
        }
    });
});
