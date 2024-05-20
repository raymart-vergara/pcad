<script type="text/javascript">
    // AJAX IN PROGRESS GLOBAL VARS
    var load_pcs_ajax_in_process = false;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        load_pcs(1);
    });

    var typingTimerLineNoSearch; // Timer identifier LineNo Search
    var typingTimerIrcsSearch; // Timer identifier Ircs Search
    var typingTimerAndonSearch; // Timer identifier Andon Search
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("line_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerLineNoSearch);
        typingTimerLineNoSearch = setTimeout(doneTypingLoadPcs, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("line_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerLineNoSearch);
    });

    // On keyup, start the countdown
    document.getElementById("ircs_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerIrcsSearch);
        typingTimerIrcsSearch = setTimeout(doneTypingLoadPcs, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ircs_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerIrcsSearch);
    });

    // On keyup, start the countdown
    document.getElementById("andon_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAndonSearch);
        typingTimerAndonSearch = setTimeout(doneTypingLoadPcs, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("andon_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAndonSearch);
    });

    // User is "finished typing," do something
    const doneTypingLoadPcs = () => {
        load_pcs(1);
    }

    // Table Responsive Scroll Event for Load More
    document.getElementById("list_of_pcs_res").addEventListener("scroll", function () {
        var scrollTop = document.getElementById("list_of_pcs_res").scrollTop;
        var scrollHeight = document.getElementById("list_of_pcs_res").scrollHeight;
        var offsetHeight = document.getElementById("list_of_pcs_res").offsetHeight;

        //check if the scroll reached the bottom
        if ((offsetHeight + scrollTop + 1) >= scrollHeight) {
            get_next_page();
        }
    });

    const get_next_page = () => {
        var current_page = parseInt(sessionStorage.getItem('list_of_pcs_table_pagination'));
        let total = sessionStorage.getItem('count_rows');
        var last_page = parseInt(sessionStorage.getItem('last_page'));
        var next_page = current_page + 1;
        if (next_page <= last_page && total > 0) {
            load_pcs(next_page);
        }
    }

    const count_pcs_list = () => {
        var line_no = document.getElementById('line_no_search').value;
        var ircs_line = document.getElementById('ircs_search').value;
        var andon_line = document.getElementById('andon_search').value;

        $.ajax({
            url: '../../process/pcs/pcs_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'count_pcs_list',
                line_no: line_no,
                ircs_line: ircs_line,
                andon_line: andon_line
            },
            success: function (response) {
                sessionStorage.setItem('count_rows', response);
                var count = `Total: ${response}`;
                $('#list_of_pcs_info').html(count);

                if (response > 0) {
                    load_pcs_last_page();
                } else {
                    document.getElementById("btnNextPage").style.display = "none";
                    document.getElementById("btnNextPage").setAttribute('disabled', true);
                }
            }
        });
    }

    const load_pcs_last_page = () => {
        var line_no = document.getElementById('line_no_search').value;
        var ircs_line = document.getElementById('ircs_search').value;
        var andon_line = document.getElementById('andon_search').value;
        var current_page = parseInt(sessionStorage.getItem('list_of_pcs_table_pagination'));
        $.ajax({
            url: '../../process/pcs/pcs_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'pcs_list_last_page',
                line_no: line_no,
                ircs_line: ircs_line,
                andon_line: andon_line
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

    const load_pcs = current_page => {
        // If an AJAX call is already in progress, return immediately
        if (load_pcs_ajax_in_process) {
            return;
        }

        var line_no = document.getElementById('line_no_search').value;
        var ircs_line = document.getElementById('ircs_search').value;
        var andon_line = document.getElementById('andon_search').value;

        var line_no1 = sessionStorage.getItem('line_no_search');
        var ircs_line1 = sessionStorage.getItem('ircs_search');
        var andon_line1 = sessionStorage.getItem('andon_search');

        if (current_page > 1) {
            switch (true) {
                case line_no !== line_no1:
                case ircs_line !== ircs_line1:
                case andon_line !== andon_line1:
                    line_no = line_no1;
                    ircs_line = ircs_line1;
                    andon_line = andon_line1;
                    break;
                default:
            }
        } else {
            sessionStorage.setItem('line_no_search', line_no);
            sessionStorage.setItem('ircs_search', ircs_line);
            sessionStorage.setItem('andon_search', andon_line);
        }

        // Set the flag to true as we're starting an AJAX call
        load_pcs_ajax_in_process = true;

        $.ajax({
            url: '../../process/pcs/pcs_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'pcs_list',
                line_no: line_no,
                ircs_line: ircs_line,
                andon_line: andon_line,
                current_page: current_page
            },
            beforeSend: () => {
                document.getElementById("btnNextPage").setAttribute('disabled', true);
                var loading = `<tr id="loading"><td colspan="8" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                if (current_page == 1) {
                    document.getElementById("list_of_pcs").innerHTML = loading;
                } else {
                    $('#list_of_pcs_table tbody').append(loading);
                }
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("btnNextPage").removeAttribute('disabled');
                if (current_page == 1) {
                    $('#list_of_pcs_table tbody').html(response);
                } else {
                    $('#list_of_pcs_table tbody').append(response);
                }
                sessionStorage.setItem('list_of_pcs_table_pagination', current_page);
                count_pcs_list();
                // Set the flag back to false as the AJAX call has completed
                load_pcs_ajax_in_process = false;
            }
        });
    }

    $("#new_pcs").on('hidden.bs.modal', e => {
        document.getElementById('line_no_master').value = '';
        document.getElementById('ircs_line_master').value = '';
        document.getElementById('andon_line_master').value = '';
        document.getElementById('final_process_master').value = '';
        document.getElementById('ip_master').value = '';
    });

    const add_pcs = () => {
        var line_no = document.getElementById('line_no_master').value;
        var ircs_line = document.getElementById('ircs_line_master').value;
        var andon_line = document.getElementById('andon_line_master').value;
        var final_process = document.getElementById('final_process_master').value;
        var ip = document.getElementById('ip_master').value;

        if (line_no == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Line No.!!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ircs_line == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IRCS Line !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (andon_line == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Andon Line !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (final_process == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Final Process !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ip == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IP Address !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else {
            $.ajax({
                url: '../../process/pcs/pcs_p.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'add_pcs',
                    line_no: line_no,
                    ircs_line: ircs_line,
                    andon_line: andon_line,
                    final_process: final_process,
                    ip: ip
                }, success: function (response) {
                    console.log(response);
                    if (response == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Succesfully Recorded!!!',
                            text: 'Success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#line_no_master').val('');
                        $('#ircs_line_master').val('');
                        $('#andon_line_master').val('');
                        $('#final_process_master').val('');
                        $('#ip_master').val('');
                        load_pcs(1);
                        $('#new_pcs').modal('hide');
                    } else if (response == 'Already Exist') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Duplicate Data !!!',
                            text: 'Information',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!!',
                            text: 'Error',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            });
        }
    }

    const get_pcs_details = (param) => {
        var string = param.split('~!~');
        var id = string[0];
        var line_no = string[1];
        var ircs_line = string[2];
        var andon_line = string[3];
        var final_process = string[4];
        var ip = string[5];

        document.getElementById('id_update').value = id;
        document.getElementById('line_no_update').value = line_no;
        document.getElementById('ircs_line_update').value = ircs_line;
        document.getElementById('andon_line_update').value = andon_line;
        document.getElementById('final_process_update').value = final_process;
        document.getElementById('ip_update').value = ip;

    }

    const update_pcs = () => {
        var id = document.getElementById('id_update').value;
        var line_no = document.getElementById('line_no_update').value;
        var ircs_line = document.getElementById('ircs_line_update').value;
        var andon_line = document.getElementById('andon_line_update').value;
        var final_process = document.getElementById('final_process_update').value;
        var ip = document.getElementById('ip_update').value;

        if (line_no == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Line No. !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ircs_line == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IRCS Line !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (andon_line == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Andon Line !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (final_process == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input Final Process !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else if (ip == '') {
            Swal.fire({
                icon: 'info',
                title: 'Please Input IP Address !!!',
                text: 'Information',
                showConfirmButton: false,
                timer: 1000
            });
        } else {
            $.ajax({
                url: '../../process/pcs/pcs_p.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'update_pcs',
                    id: id,
                    line_no: line_no,
                    ircs_line: ircs_line,
                    andon_line: andon_line,
                    final_process: final_process,
                    ip: ip
                }, success: function (response) {
                    console.log(response);
                    if (response == 'success') {
                        console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Succesfully Recorded!!!',
                            text: 'Success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#id_update').val('');
                        $('#line_no_update').val('');
                        $('#ircs_line_update').val('');
                        $('#andon_line_update').val('');
                        $('#final_process_update').val('');
                        $('#ip_update').val('');
                        load_pcs(1);
                        $('#updatepcs').modal('hide');
                    } else if (response == 'Already Exist') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Duplicate Data !!!',
                            text: 'Information',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!!',
                            text: 'Error',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            });
        }
    }

    const delete_pcs = () => {
        var id = document.getElementById('id_update').value;
        $.ajax({
            url: '../../process/pcs/pcs_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_pcs',
                id: id
            }, success: function (response) {
                console.log(response);
                if (response == 'success') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Succesfully Deleted !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    load_pcs(1);
                    $('#updatepcs').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        });
    }

    // uncheck all
    const uncheck_all = () => {
        var select_all = document.getElementById('check_all');
        select_all.checked = false;
        document.querySelectorAll(".singleCheck").forEach((el, i) => {
            el.checked = false;
        });
        get_checked_length();
    }
    // check all
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

    // GET THE LENGTH OF CHECKED CHECKBOXES
    const get_checked_length = () => {
        var arr = [];
        document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
            arr.push(el.value);
        });
        console.log(arr);
        var numberOfChecked = arr.length;
        console.log(numberOfChecked);
        if (numberOfChecked > 0) {
            document.getElementById("count_delete_pcs_selected").innerHTML = `${numberOfChecked} Row/s Selected`;
            document.getElementById("btnDeleteSelected").removeAttribute('disabled');
        } else {
            document.getElementById("btnDeleteSelected").setAttribute('disabled', true);
        }
    }

    const delete_pcs_selected = () => {
        var arr = [];
        document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
            arr.push(el.value);
        });
        console.log(arr);
        var numberOfChecked = arr.length;
        if (numberOfChecked > 0) {
            id_arr = Object.values(arr);
            $.ajax({
                url: '../../process/pcs/pcs_p.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'delete_pcs_selected',
                    id_arr: id_arr
                }, success: function (response) {
                    console.log('response');
                    if (response == 'success') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Succesfully Deleted !!!',
                            text: 'Information',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        load_pcs(1);
                        document.getElementById("btnDeleteSelected").setAttribute('disabled', true);
                        $('#delete_pcs_selected').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!!',
                            text: 'Error',
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

    function fetchFinalProcess() {
        $.ajax({
            url: '../../process/pcs/pcs_p.php',
            method: 'POST',
            data: {
                method: 'final_process'
            },
            dataType: 'html',
            success: function (response) {
                $('#final_process_master').html(response);
            },
            error: function () {
                console.error('Error fetching data');
                $('#final_process_master').html('<option>Error fetching data</option>');
            }
        });
    }

    $(document).ready(function () {
        fetchFinalProcess();
    });

</script>