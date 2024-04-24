<script type="text/javascript">
    var timer = 4000;
    var interval = 2000;
    var barWidth = $('.bar').innerWidth() - 12;
    var processing = $('#processing').val();
    var timerTakt = $("#last_takt").val();
    var timerOn = true;
    var isPause = false;

    getDT();

    // $('.done').addClass('d-none');
    // $('.running').removeClass('d-none');
    if ($('#takt').val() == 0) {
        $('.btn-resume').addClass('d-none');
        $('.btn-pause').addClass('d-none');
    }

    checkPausedStatus();

    function checkPausedStatus() {
        if ($("#is_paused").val() == "YES") {
            isPause = true;
            $('.btn-resume').removeClass('d-none');
            $('.btn-pause').addClass('d-none');

        } else {
            isPause = false;
            $('.btn-pause').removeClass('d-none');
            $('.btn-resume').addClass('d-none');
        }

        $(".takt-value").text(moment.utc(timerTakt * 1000).format('HH:mm:ss'));
        var takt = $('#takt').val();
        var taktset = moment.utc(takt * 1000).format('HH:mm:ss');
        $('#taktset').text(taktset);
    }

    if (processing == 1) {
        getValues();
        setInterval(function () {
            if (timerOn == true && isPause == false) {
                var loadingWidth = $('.loading').width();
                if (loadingWidth >= (barWidth - 200)) {
                    $('.plan_target_value').removeClass('reloadedLine');
                    $('.plan_actual_value').removeClass('reloadedLine');
                    $('.plan_gap_value').removeClass('reloadedLine');
                    $('.plan_gap_value').css('padding-top', '0');
                }
                if (loadingWidth <= barWidth) {
                    $('.loading').css('width', (loadingWidth + 7) + 'px');
                } else {
                    $('.loading').css('width', '0px');
                    getValues();
                }
            }
        }, interval);

        function getValues() {
            var registlinename = $("#registlinename").val();
            var last_takt = $("#last_takt").val();
            var added_takt_plan = $("#added_takt_plan").val();
            // console.log(registlinename);
            $.post('process/pcs/dashboard_setting_p.php', {
                request: 'getPlanLine',
                registlinename: registlinename,
                last_takt: last_takt
            }, function (response) {
                fetch_digit();
                console.log(response);

                if ($('.plan_target_value').text() != response.plan) {
                    $('.plan_target_value').addClass('reloadedLine');
                    $('.plan_target_value').css('margin-top', '-100px');
                }

                if ($('.plan_actual_value').text() != response.actual) {
                    $('.plan_actual_value').addClass('reloadedLine');
                    $('.plan_actual_value').css('margin-top', '-100px');
                }

                if ($('.plan_gap_value').text() != response.remaining) {
                    $('.plan_gap_value').addClass('reloadedLine');
                    $('.plan_gap_value').css('margin-top', '-100px');
                }

                $('.plan_target_value').text(parseInt(response.plan));
                $('.plan_actual_value').text(parseInt(response.actual));
                $('.plan_gap_value').text(response.remaining);
            });
        }

        setInterval(function () {
            if (timerOn == true) {
                if (isPause == false) {

                    var takttimer = moment.utc(timerTakt * 1000).format('HH:mm:ss');
                    var takt = $('#takt').val();
                    var taktset = moment.utc(takt * 1000).format('HH:mm:ss');
                    $("#last_takt").val(timerTakt);

                    if (takt != 0) {
                        $('.takt-value').text(takttimer);
                        $('#taktset').text(taktset);
                    } else {
                        $('.takt-value').text('N/A');
                        $('#taktset').text('(N/A)');
                    }
                    timerTakt++;

                    if (takt != 0) {
                        if (timerTakt > takt) {
                            //update takt time
                            timerTakt = 0;
                            updateTakt();
                        }
                    }
                }
            }

        }, 1000);

    } else {
        $(document).ready(function () {
            $('#plannotset').modal('show');
        });
    }

    setInterval(function () {
        getDT();
    }, 1000);

    function getDT() {
        var datenow = moment().format('YYYY/MM/DD hh:mm:ss A');
        $('.datenow').text(datenow);
    }

    function updateTakt() {
        var added_takt_plan = $("#added_takt_plan").val();
        $.post('process/pcs/dashboard_setting_p.php', {
            request: 'updateTakt',
            registlinename: $('#registlinename').val(),
            added_takt_plan: added_takt_plan
        }, function (response) {
            if (response.trim() == "true") {
                getValues();
            }
        });
    }

    // ---EVENT LISTENER -----------------------------------------------------------------
    // END TARGET USING KEY NUMBER 2 -----------------------------------------------------------------------------
    // RESUME BUTTON
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