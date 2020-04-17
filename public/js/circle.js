$(document).ready(function () {
    const canvas = document.getElementById('pole');
    const context = canvas.getContext('2d');

    getPoints();

    $('#new-circle').click(function () {
        $.ajax({
            url: '/circle/create',
            type: 'get',
            success: function (data) {
                let res = JSON.parse(data);
                setPoint(res.centerX, res.centerY, res.radius, res.hex)
            }
        });
    });

    $('#check').click(function () {
        $.ajax({
            url: '/circle/intersections',
            type: 'get',
            success: function (data) {
                let res = JSON.parse(data);
                if (Number.isInteger(res)) {
                    $('#count-circles').html(res);
                    $('#check-modal').modal("show");
                }

            }
        });
    });

    $('#clear').click(function () {
        $.ajax({
            url: '/circle/clear',
            type: 'get',
            success: function (data) {
                let res = JSON.parse(data);
                if (res.error) {
                    $('#error-modal').html(res.message);
                } else {
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    $('#check-modal').modal("hide");
                }
            }
        });
    });

    function getPoints() {
        $.ajax({
            url: '/circle/get',
            type: 'get',
            success: function (data) {
                let res = JSON.parse(data);
                for (let i = 0; i < res.length; i++) {
                    setPoint(res[i].centerX, res[i].centerY, res[i].radius, res[i].hex)
                }
            }
        });
    }

    function setPoint(centerX, centerY, radius, color) {
        context.beginPath();
        context.arc(centerX, centerY, radius, 0, Math.PI * 2, false);
        context.closePath();
        context.fillStyle = color;
        context.fill();
    }
});

