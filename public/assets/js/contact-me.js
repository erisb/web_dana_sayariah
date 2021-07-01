jQuery(document).ready(function () {

    $('form#formcontactus').submit(function () {
        $('form#formcontactus .error-form').remove();
        $('form#formcontactus .success').remove();
        var hasError = false;
        $('.requiretop').each(function () {
            if (jQuery.trim($(this).val()) === '') {
                $(this).parent().append('<span class="error-form flash animated"><i class="fa fa-exclamation-triangle"></i></span>');
                hasError = true;
            } else if ($(this).hasClass('email')) {
                var emailReg = /^([\w-\.]+@([\w]+\.)+[\w]{2,4})?$/;
                if (!emailReg.test(jQuery.trim($(this).val()))) {
                    $(this).parent().append('<span class="error-form flash animated"><i class="fa fa-exclamation-triangle"></i></span>');
                    hasError = true;
                }
            }
        });
        if (!hasError) {
            formInput = $(this).serialize();
            $.post($(this).attr('action'), formInput, function (data) {
                $('form#formcontactus').append('<div class="alert animated-middle fadeIn alert-success alert-dismissable"><strong><i class="fa fa-check"></i> Your message has been sent, we will get back to you asap !</strong></div>');
                setTimeout(function() {
                    $(".alert-success").addClass("fadeOut");
                }, 5000);

                setTimeout(function() {
                    $(".alert-success").addClass("display-none");
                }, 6000);

            });
            $('.requiretop').val('');
				
        }
        return false;
    });
    $('form#formcontactus input').focus(function () {
        $('form#formcontactus .error-form').remove();
        $('form#formcontactus .success').remove();
    });
    $('form#formcontactus textarea').focus(function () {
        $('form#formcontactus .error-form').remove();
        $('form#formcontactus .success').remove();
    });

});