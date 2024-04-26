<script type="text/javascript">
    var processing = $('#processing').val();
    var timerTakt = $("#last_takt").val();

    getDT();

    // $('.done').addClass('d-none');
    // $('.running').removeClass('d-none');
    if ($('#takt').val() == 0) {
        $('.btn-resume').addClass('d-none');
        $('.btn-pause').addClass('d-none');
    }

    if (processing == 1) {
        getValues();
        
        // function getValues() {
        //     var registlinename = $("#registlinename").val();
        //     var last_takt = $("#last_takt").val();
        //     var added_takt_plan = $("#added_takt_plan").val();
        //     // console.log(registlinename);
        //     $.post('process/pcs/setting_p.php', {
        //         request: 'getPlanLine',
        //         registlinename: registlinename,
        //         last_takt: last_takt
        //     }, function(response) {
        //         fetch_digit();
        //         console.log(response);

        //         if ($('.plan_target_value').text() != response.plan) {
        //             $('.plan_target_value').addClass('reloadedLine');
        //             $('.plan_target_value').css('margin-top', '-100px');
        //         }

        //         if ($('.plan_actual_value').text() != response.actual) {
        //             $('.plan_actual_value').addClass('reloadedLine');
        //             $('.plan_actual_value').css('margin-top', '-100px');
        //         }

        //         if ($('.plan_gap_value').text() != response.remaining) {
        //             $('.plan_gap_value').addClass('reloadedLine');
        //             $('.plan_gap_value').css('margin-top', '-100px');
        //         }
        //         $('.plan_target_value').text(parseInt(response.plan));
        //         $('.plan_actual_value').text(parseInt(response.actual));
        //         $('.plan_gap_value').text(response.remaining);
        //     });

        // }

        function getValues() {
            var registlinename = $("#registlinename").val();
            var last_takt = $("#last_takt").val();
            var added_takt_plan = $("#added_takt_plan").val();

            $.post('process/pcs/setting_p.php', {
                request: 'getPlanLine',
                registlinename: registlinename,
                last_takt: last_takt
            }, function (response) {
                fetch_digit();
                console.log(response);

                var plan_target_value = $('.plan_target_value');
                plan_target_value.text(parseInt(response.plan));
                if (parseInt(plan_target_value.text()) != response.plan) {
                    plan_target_value.addClass('reloadedLine');
                }

                var plan_actual_value = $('.plan_actual_value');
                plan_actual_value.text(parseInt(response.actual));
                if (parseInt(plan_actual_value.text()) != response.actual) {
                    plan_actual_value.addClass('reloadedLine');
                }

                var plan_gap_value = $('.plan_gap_value');
                plan_gap_value.text(response.remaining);
                if (parseInt(plan_gap_value.text()) < 0) {
                    plan_gap_value.css('background-color', '#FD5A46');
                    plan_gap_value.css('color', '#000');
                } else if (parseInt(plan_gap_value.text()) > 0) {
                    plan_gap_value.css('background-color', '#ABD2FA');
                    plan_gap_value.css('color', '#000');
                } else {
                    plan_gap_value.css('background-color', '#ABD2FA');
                    plan_gap_value.css('color', '#000');
                }
                if (parseInt(plan_gap_value.text()) != response.remaining) {
                    plan_gap_value.addClass('reloadedLine');
                }
            });
        }

    } else {
        $(document).ready(function() {
            $('#plannotset').modal('show');
        });
    }

    setInterval(function() {
        getDT();
    }, 1000);

    function getDT() {
        var datenow = moment().format('YYYY/MM/DD hh:mm:ss A');
        $('.datenow').text(datenow);
    }

    // TIMER FOR DIGIT LENGTH CHECK

    function fetch_digit() {
        var plan_length = $('#plan_target').text().length;
        var actual_length = $('#plan_actual').text().length;
        var diff_length = $('#plan_gap').text().length;
        console.log(plan_length);
        console.log(actual_length);
        console.log(diff_length);

        // if (plan_length >= 3 && actual_length >= 3 && diff_length >= 3) {
        //     $('#fit_style').html('.bar{zoom:50%;}');
        // } else if (plan_length >= 3 && actual_length >= 1 && diff_length >= 3) {
        //     $('#fit_style').html('.bar{zoom:55%;}');
        // } else if (plan_length >= 3 && actual_length >= 3 && diff_length >= 1) {
        //     $('#fit_style').html('.bar{zoom:55%;}');
        // } else if (plan_length >= 3 && actual_length >= 2 && diff_length >= 2) {
        //     $('#fit_style').html('.bar{zoom:55%;}');
        // } else if (plan_length >= 3 && actual_length >= 2 && diff_length >= 3) {
        //     $('#fit_style').html('.bar{zoom:55%;}');
        // } else if (plan_length >= 2 && actual_length >= 2 && diff_length >= 3) {
        //     $('#fit_style').html('.bar{zoom:65%;}');
        // } else {
        //     $('#fit_style').html('.bar{zoom:65%;}');
        // }
    }
</script>