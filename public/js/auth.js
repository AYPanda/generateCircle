$(document).ready(function () {
    $('.btnLogin').click(function () {
        $(".error").html("");

        let login = $('#login').val();
        let password = $('#password').val();

        $.ajax({
            url: '/authorize/login',
            type: 'post',
            data: {login, password},
            success: function (data) {
                let res = JSON.parse(data);

                if (res.error) {
                    $(".error").html(res.message);
                    return;
                }
                window.location.href = "/";
            }
        });
    });
});

