<script type="text/javascript">
    // AJAX IN PROGRESS GLOBAL VARS
    var load_insp_ajax_in_process = false;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        load_insp(1);
        fetch_process();
        fetch_ip_address_column();
        fetch_finish_date_time();
        fetch_judgement();
    });

    var typingTimerLineNoInspSearch; // Timer identifier IrcsLineInsp Search
    var typingTimerIrcsLineInspSearch; // Timer identifier IrcsLineInsp Search
    var typingTimerProcessInspSearch; // Timer identifier ProcessInsp Search
    var typingTimerIPAddressInspSearch; // Timer identifier ProcessInsp Search
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("line_no_insp_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerIrcsLineInspSearch);
        typingTimerIrcsLineInspSearch = setTimeout(doneTypingLoadInsp, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("line_no_insp_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerIrcsLineInspSearch);
    });

    // On keyup, start the countdown
    document.getElementById("ircs_line_insp_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerIrcsLineInspSearch);
        typingTimerIrcsLineInspSearch = setTimeout(doneTypingLoadInsp, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ircs_line_insp_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerIrcsLineInspSearch);
    });

    // On keyup, start the countdown
    document.getElementById("process_insp_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerProcessInspSearch);
        typingTimerProcessInspSearch = setTimeout(doneTypingLoadInsp, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("process_insp_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerProcessInspSearch);
    });

    // On keyup, start the countdown
    document.getElementById("ip_address_insp_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerProcessInspSearch);
        typingTimerProcessInspSearch = setTimeout(doneTypingLoadInsp, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ip_address_insp_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerProcessInspSearch);
    });

    // User is "finished typing," do something
    const doneTypingLoadInsp = () => {
        load_insp(1);
    }

    function fetch_process() {
        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'fetch_process'
            },
            dataType: 'html',
            success: function (response) {
                $('#process_insp_master').html(response);
            },
            error: function () {
                console.error('Error fetching data');
                $('#process_insp_master').html('<option>Error fetching data</option>');
            }
        });
    }

    function fetch_ip_address_column() {
        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'fetch_ip_address_column'
            },
            dataType: 'html',
            success: function (response) {
                $('#ip_address_column_insp_master').html(response);
            },
            error: function () {
                console.error('Error fetching data');
                $('#ip_address_column_insp_master').html('<option>Error fetching data</option>');
            }
        });
    }

    function fetch_finish_date_time() {
        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'fetch_finish_date_time'
            },
            dataType: 'html',
            success: function (response) {
                $('#finish_date_time_insp_master').html(response);
            },
            error: function () {
                console.error('Error fetching data');
                $('#finish_date_time_insp_master').html('<option>Error fetching data</option>');
            }
        });
    }

    function fetch_judgement() {
        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'fetch_judgement'
            },
            dataType: 'html',
            success: function (response) {
                $('#judgement_insp_master').html(response);
            },
            error: function () {
                console.error('Error fetching data');
                $('#judgement_insp_master').html('<option>Error fetching data</option>');
            }
        });
    }

    // Table Responsive Scroll Event for Load More
    document.getElementById("list_of_insp_res").addEventListener("scroll", function () {
        var scrollTop = document.getElementById("list_of_insp_res").scrollTop;
        var scrollHeight = document.getElementById("list_of_insp_res").scrollHeight;
        var offsetHeight = document.getElementById("list_of_insp_res").offsetHeight;

        //check if the scroll reached the bottom
        if ((offsetHeight + scrollTop + 1) >= scrollHeight) {
            get_next_page();
        }
    });

    const get_next_page = () => {
        var current_page = parseInt(sessionStorage.getItem('list_of_insp_table_pagination'));
        let total = sessionStorage.getItem('count_rows');
        var last_page = parseInt(sessionStorage.getItem('last_page'));
        var next_page = current_page + 1;
        if (next_page <= last_page && total > 0) {
            load_insp(next_page);
        }
    }

    const count_insp_list = () => {
        var line_no = document.getElementById('line_no_insp_search').value;
        var ircs_line = document.getElementById('ircs_line_insp_search').value;
        var process = document.getElementById('process_insp_search').value;
        var ip_address = document.getElementById('ip_address_insp_search').value;

        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'count_insp_list',
                line_no: line_no,
                ircs_line: ircs_line,
                process: process,
                ip_address: ip_address
            },
            success: function (response) {
                sessionStorage.setItem('count_rows', response);
                var count = `Total: ${response}`;
                $('#list_of_insp_info').html(count);

                if (response > 0) {
                    load_insp_last_page();
                } else {
                    document.getElementById("btnNextPage").style.display = "none";
                    document.getElementById("btnNextPage").setAttribute('disabled', true);
                }
            }
        });
    }

    const load_insp_last_page = () => {
        var line_no = document.getElementById('line_no_insp_search').value;
        var ircs_line = document.getElementById('ircs_line_insp_search').value;
        var process = document.getElementById('process_insp_search').value;
        var ip_address = document.getElementById('ip_address_insp_search').value;
        var current_page = parseInt(sessionStorage.getItem('list_of_insp_table_pagination'));
        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'insp_list_last_page',
                line_no: line_no,
                ircs_line: ircs_line,
                process: process,
                ip_address: ip_address
            },
            success: function (response) {
                sessionStorage.setItem('last_page', response);
                let total = sessionStorage.getItem('count_rows');
                var next_page = current_page + 1;
                if (next_page > response || total < 1) {
                    document.getElementById("btnNextPage").style.display = "none";
                    document.getElementById("btnNextPage").setAttribute('disabled', true);
                } else {
                    document.getElementById("btnNextPage").style.display = "block";
                    document.getElementById("btnNextPage").removeAttribute('disabled');
                }
            }
        });
    }

    const load_insp = current_page => {
        // If an AJAX call is already in progress, return immediately
        if (load_insp_ajax_in_process) {
            return;
        }

        var line_no = document.getElementById('line_no_insp_search').value;
        var ircs_line = document.getElementById('ircs_line_insp_search').value;
        var process = document.getElementById('process_insp_search').value;
        var ip_address = document.getElementById('ip_address_insp_search').value;

        var line_no1 = sessionStorage.getItem('line_no_insp_search');
        var ircs_line1 = sessionStorage.getItem('ircs_line_insp_search');
        var process1 = sessionStorage.getItem('process_insp_search');
        var ip_address1 = sessionStorage.getItem('ip_address_insp_search');

        if (current_page > 1) {
            switch (true) {
                case line_no !== line_no1:
                case ircs_line !== ircs_line1:
                case process !== process1:
                case ip_address !== ip_address1:
                    line_no = line_no1;
                    ircs_line = ircs_line1;
                    process = process1;
                    ip_address = ip_address1;
                    break;
                default:
            }
        } else {
            sessionStorage.setItem('line_no_insp_search', ircs_line);
            sessionStorage.setItem('ircs_line_insp_search', ircs_line);
            sessionStorage.setItem('process_insp_search', process);
            sessionStorage.setItem('ip_address_insp_search', ip_address);
        }

        // Set the flag to true as we're starting an AJAX call
        load_insp_ajax_in_process = true;

        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'inspection_list',
                line_no:line_no,
                ircs_line: ircs_line,
                process: process,
                ip_address: ip_address,
                current_page: current_page
            },
            beforeSend: () => {
                document.getElementById("btnNextPage").setAttribute('disabled', true);
                var loading = `<tr id="loading"><td colspan="8" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                if (current_page == 1) {
                    document.getElementById("list_of_insp").innerHTML = loading;
                } else {
                    $('#list_of_insp_table tbody').append(loading);
                }
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("btnNextPage").removeAttribute('disabled');
                if (current_page == 1) {
                    $('#list_of_insp_table tbody').html(response);
                } else {
                    $('#list_of_insp_table tbody').append(response);
                }
                sessionStorage.setItem('list_of_insp_table_pagination', current_page);
                count_insp_list();
                // Set the flag back to false as the AJAX call has completed
                load_insp_ajax_in_process = false;
            }
        });
    }

    $("#new_insp").on('hidden.bs.modal', e => {
        document.getElementById('ircs_line_insp_master').value = '';
        document.getElementById('process_insp_master').value = '';
        document.getElementById('ip_address_1_insp_master').value = '';
        document.getElementById('ip_address_2_insp_master').value = '';
        document.getElementById('finish_date_time_insp_master').value = '';
        document.getElementById('judgement_insp_master').value = '';
    });

    const add_insp = () => {
        var line_no = document.getElementById('line_no_insp_master').value;
        var ircs_line = document.getElementById('ircs_line_insp_master').value;
        var process = document.getElementById('process_insp_master').value;
        var ip_address_1 = document.getElementById('ip_address_1_insp_master').value;
        var ip_address_2 = document.getElementById('ip_address_2_insp_master').value;
        var ip_address_col = document.getElementById('ip_address_column_insp_master').value;
        var finish_date_time = document.getElementById('finish_date_time_insp_master').value;
        var judgement = document.getElementById('judgement_insp_master').value;

        if (line_no == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Line No.',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ircs_line == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IRCS Line',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (process == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Process',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ip_address_1 == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IP Address 1',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ip_address_col == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IP Address Column',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (finish_date_time == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Finish Date Time',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (judgement == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Judgement',
                showConfirmButton: false,
                timer: 1000
            });
        } else {
            $.ajax({
                url: '../../process/pcs/inspection_p.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'add_insp',
                    line_no: line_no,
                    ircs_line: ircs_line,
                    process: process,
                    ip_address_1: ip_address_1,
                    ip_address_2: ip_address_2,
                    ip_address_col: ip_address_col,
                    finish_date_time: finish_date_time,
                    judgement: judgement
                }, success: function (response) {
                    console.log(response);
                    if (response == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Recorded!!!',
                            text: 'Success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#line_no_insp_master').val('');
                        $('#ircs_line_insp_master').val('');
                        $('#process_insp_master').val('');
                        $('#ip_address_1_insp_master').val('');
                        $('#ip_address_2_insp_master').val('');
                        $('#ip_address_column_insp_master').val('');
                        $('#finish_date_time_insp_master').val('');
                        $('#judgement_insp_master').val('');
                        load_insp(1);
                        $('#new_insp').modal('hide');
                    } else if (response == 'Already Exist') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Duplicate Data',
                            showConfirmButton: false,
                            timer: 1000
                        });
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
        }
    }

    const get_insp_details = (param) => {
        var string = param.split('~!~');
        var id = string[0];
        var line_no = string[1];
        var ircs_line = string[2];
        var process = string[3];
        var ip_address_1 = string[4];
        var ip_address_2 = string[5];
        var ip_address_col = string[6];
        var finish_date_time = string[7];
        var judgement = string[8];

        document.getElementById('id_insp_update').value = id;
        document.getElementById('line_no_insp_master_update').value = line_no;
        document.getElementById('ircs_line_insp_master_update').value = ircs_line;
        document.getElementById('process_insp_master_update').value = process;
        document.getElementById('ip_address_1_insp_master_update').value = ip_address_1;
        document.getElementById('ip_address_2_insp_master_update').value = ip_address_2;
        document.getElementById('ip_address_column_insp_master_update').value = ip_address_col;
        document.getElementById('finish_date_time_insp_master_update').value = finish_date_time;
        document.getElementById('judgement_insp_master_update').value = judgement;
    }

    const update_insp = () => {
        var id = document.getElementById('id_insp_update').value;
        var line_no = document.getElementById('line_no_insp_master_update').value;
        var ircs_line = document.getElementById('ircs_line_insp_master_update').value;
        var process = document.getElementById('process_insp_master_update').value;
        var ip_address_1 = document.getElementById('ip_address_1_insp_master_update').value;
        var ip_address_2 = document.getElementById('ip_address_2_insp_master_update').value;
        var ip_address_col = document.getElementById('ip_address_column_insp_master_update').value;
        var finish_date_time = document.getElementById('finish_date_time_insp_master_update').value;
        var judgement = document.getElementById('judgement_insp_master_update').value;

        if (line_no == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Line No.',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ircs_line == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IRCS Line',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (process == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Process',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ip_address_1 == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IP Address 1',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ip_address_col == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IP Address Column',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (finish_date_time == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Finish Date Time',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (judgement == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Judgement Column',
                showConfirmButton: false,
                timer: 1000
            });
        } else {
            $.ajax({
                url: '../../process/pcs/inspection_p.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'update_insp',
                    id: id,
                    line_no: line_no,
                    ircs_line: ircs_line,
                    process: process,
                    ip_address_1: ip_address_1,
                    ip_address_2: ip_address_2,
                    ip_address_col: ip_address_col,
                    finish_date_time:finish_date_time,
                    judgement:judgement
                }, success: function (response) {
                    console.log(response);
                    if (response == 'success') {
                        console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully Recorded!!!',
                            text: 'Success',
                            showConfirmButton: false,
                            timer: 500
                        });
                        $('#id_insp_update').val('');
                        $('#line_no_insp_master_update').val('');
                        $('#ircs_line_insp_master_update').val('');
                        $('#process_insp_master_update').val('');
                        $('#ip_address_1_insp_master_update').val('');
                        $('#ip_address_2_insp_master_update').val('');
                        $('#ip_address_column_insp_master_update').val('');
                        $('#finish_date_time_insp_master_update').val('');
                        $('#judgement_insp_master_update').val('');
                        load_insp(1);
                        $('#update_modal_insp').modal('hide');
                    } else if (response == 'Already Exist') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Duplicate Data',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            })
        }
    }

    const delete_insp = () => {
        var id = document.getElementById('id_insp_update').value;
        $.ajax({
            url: '../../process/pcs/inspection_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_insp',
                id: id
            }, success: function (response) {
                console.log(response);
                if (response == 'success') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Successfully Deleted',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    load_insp(1);
                    $('#update_modal_insp').modal('hide');
                }
            }
        })
    }

    const uncheck_all = () => {
        var select_all = document.getElementById('check_all');
        select_all.checked = false;
        document.querySelectorAll(".singleCheck").forEach((el, i) => {
            el.checked = false;
        });
        get_checked_length();
    }

    const select_all_func = () => {
        var select_all = document.getElementById('check_all');
        if (select_all.checked == true) {
            console.log('check');
            document.querySelectorAll(".singleCheck").forEach((el, i) => {
                el.checked = true;
            });
        } else {
            console.log('uncheck');
            document.querySelectorAll(".singleCheck").forEach((el, i) => {
                el.checked = false;
            });
        }
        get_checked_length();
    }

    const get_checked_length = () => {
        var arr = [];
        document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
            arr.push(el.value);
        });
        console.log(arr);
        var numberOfChecked = arr.length;
        console.log(numberOfChecked);
        if (numberOfChecked > 0) {
            document.getElementById("count_delete_insp_selected").innerHTML = `${numberOfChecked} Row/s Selected`;
            document.getElementById("btnDeleteSelected").removeAttribute('disabled');
        } else {
            document.getElementById("btnDeleteSelected").setAttribute('disabled', true);
        }
    }

    const delete_insp_selected = () => {
        var arr = [];
        document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
            arr.push(el.value);
        });
        console.log(arr);
        var numberOfChecked = arr.length;
        if (numberOfChecked > 0) {
            id_arr = Object.values(arr);
            $.ajax({
                url: '../../process/pcs/inspection_p.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'delete_insp_selected',
                    id_arr: id_arr
                }, success: function (response) {
                    console.log('response');
                    if (response == 'success') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Successfully Deleted',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        load_insp(1);
                        document.getElementById("btnDeleteSelected").setAttribute('disabled', true);
                        $('#delete_insp_selected').modal('hide');
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
        } else {
            Swal.fire({
                icon: 'info',
                title: 'No Row Selected',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        }
    }
</script>