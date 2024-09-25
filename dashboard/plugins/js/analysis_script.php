<script type="text/javascript">
    $(document).ready(function () {
        // load_analysis();

        const registlinename = localStorage.getItem('registlinename');
        const line_no = localStorage.getItem('pcad_line_no');
        const exec_date = localStorage.getItem('pcad_exec_server_date_only');
        const shift = localStorage.getItem('shift');
        const opt = localStorage.getItem('pcad_exec_opt');

        if (registlinename && line_no && exec_date && shift && opt) {
            load_analysis(registlinename, line_no, exec_date, shift, opt);
        } else {
            console.error('Required localStorage values are missing.');
        }

        autoFillDateTime();

        $('#add_analysis').on('show.bs.modal', function () {
            autoFillDateTime();
        });
    });


    function autoFillDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

        document.getElementById('a_datetime').value = formattedDateTime;

        document.getElementById('a_datetime_update').value = formattedDateTime;
    }

    // const load_analysis = () => {
    //     $.ajax({
    //         // url: 'process/pcad/analysis_p.php',
    //         url: 'process/pcs/dashboard_setting_p.php',
    //         type: 'POST',
    //         cache: false,
    //         data: {
    //             method: 'analysis_list',
    //         }, success: function (response) {
    //             $('#list_of_analysis').html(response);
    //             $('#spinner').fadeOut();
    //         }
    //     });
    // }

    const load_analysis = (registlinename, line_no, exec_date, shift, opt) => {
        $.ajax({
            url: 'process/pcs/dashboard_setting_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'analysis_list',
                registlinename: registlinename,
                pcad_line_no: line_no,
                pcad_exec_server_date_only: exec_date,
                shift: shift,
                pcad_exec_opt: opt
            },
            success: function (response) {
                console.log("Response:", response);  // Log the response
                $('#list_of_analysis').html(response);
                $('#spinner').fadeOut();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    }

    const add_analysis = () => {
        var problem = document.getElementById('a_problem').value.replace(/\n/g, '\\n');
        var recommendation = document.getElementById('a_recommendation').value.replace(/\n/g, '\\n');
        var dri = document.getElementById('a_dri').value;
        var dept = document.getElementById('a_department').value;
        var date_recorded = document.getElementById('a_datetime').value;
        var prepared_by = document.getElementById('a_prepared_by').value;
        var reviewed_by = document.getElementById('a_reviewed_by').value;

        if (!problem || !recommendation || !dri || !dept || !date_recorded || !prepared_by || !reviewed_by) {
            Swal.fire({
                icon: 'warning',
                title: 'Please fill in all required fields. (*)',
                showConfirmButton: true
            });
            return;
        }

        // Get values from local storage
        var registlinename = localStorage.getItem('registlinename');
        var line_no = localStorage.getItem('pcad_line_no');
        var exec_date = localStorage.getItem('pcad_exec_server_date_only');
        var shift = localStorage.getItem('shift');
        var opt = localStorage.getItem('pcad_exec_opt');

        $.ajax({
            url: 'process/pcs/dashboard_setting_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_analysis',
                problem: problem,
                recommendation: recommendation,
                dri: dri,
                dept: dept,
                date_recorded: date_recorded,
                prepared_by: prepared_by,
                reviewed_by: reviewed_by,
                registlinename: registlinename,
                line_no: line_no,
                exec_date: exec_date,
                shift: shift,
                opt: opt
            },
            success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Recorded Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Clear the fields after success
                    $('#a_problem').val('');
                    $('#a_recommendation').val('');
                    $('#a_dri').val('');
                    $('#a_department').val('');
                    $('#a_datetime').val('');
                    $('#a_prepared_by').val('');
                    $('#a_reviewed_by').val('');

                    // load_analysis();
                    load_analysis(registlinename, line_no, exec_date, shift, opt);

                    $('#add_analysis').modal('hide');

                    $('html, body').animate({
                        scrollTop: $('#analysis_table').offset().top
                    }, 500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        });
    };

    const get_analysis_details = (param) => {
        var string = param.split(',');
        var id = string[0];
        var problem = string[1];
        var recommendation = string[2];
        var dri = string[3];
        var department = string[4];
        var date_recorded = string[5];
        var prepared_by = string[6];
        var reviewed_by = string[7];

        document.getElementById('id_analysis_update').value = id;
        document.getElementById('a_problem_update').value = problem;
        document.getElementById('a_recommendation_update').value = recommendation;
        document.getElementById('a_dri_update').value = dri;
        document.getElementById('a_department_update').value = department;
        document.getElementById('a_datetime_update').value = date_recorded;
        document.getElementById('a_prepared_by_update').value = prepared_by;
        document.getElementById('a_reviewed_by_update').value = reviewed_by;
    }

    const update_analysis = () => {
        var id = document.getElementById('id_analysis_update').value;
        var problem = document.getElementById('a_problem_update').value.replace(/\n/g, '\\n');
        var recommendation = document.getElementById('a_recommendation_update').value.replace(/\n/g, '\\n');
        var dri = document.getElementById('a_dri_update').value;
        var department = document.getElementById('a_department_update').value;
        var date_recorded = document.getElementById('a_datetime_update').value;
        var prepared_by = document.getElementById('a_prepared_by_update').value;
        var reviewed_by = document.getElementById('a_reviewed_by_update').value;

        var registlinename = localStorage.getItem('registlinename');
        var line_no = localStorage.getItem('pcad_line_no');
        var exec_date = localStorage.getItem('pcad_exec_server_date_only');
        var shift = localStorage.getItem('shift');
        var opt = localStorage.getItem('pcad_exec_opt');

        $.ajax({
            url: 'process/pcs/dashboard_setting_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_analysis',
                id: id,
                problem: problem,
                recommendation: recommendation,
                dri: dri,
                department: department,
                date_recorded: date_recorded,
                prepared_by: prepared_by,
                reviewed_by: reviewed_by,
                registlinename: registlinename,
                line_no: line_no,
                exec_date: exec_date,
                shift: shift,
                opt: opt
            },
            success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated Successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Clear the fields after success
                    $('#a_problem_update').val('');
                    $('#a_recommendation_update').val('');
                    $('#a_dri_update').val('');
                    $('#a_department_update').val('');
                    $('#a_prepared_by_update').val('');
                    $('#a_reviewed_by_update').val('');

                    // load_analysis();
                    load_analysis(registlinename, line_no, exec_date, shift, opt);

                    $('#update_analysis').modal('hide');

                    $('html, body').animate({
                        scrollTop: $('#analysis_table').offset().top
                    }, 500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        });
    };


</script>