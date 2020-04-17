$(document).ready(function () {
    $('#feedback').click(function () {
        $("#myModalBox").modal('show');
    });
    $('#logout').click(function () {
        $.ajax({
            url: '/authorize/logout',
            type: 'get',
            success: function (data) {
                window.location.href = '/authorize';
            }
        });
    });
});

