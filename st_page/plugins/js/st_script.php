<script type="text/javascript">
    // AJAX IN PROGRESS GLOBAL VARS
    var load_st_ajax_in_process = false;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        load_st(1);
    });

    var typingTimerPartsNameMasterSearch; // Timer identifier PartsName Search
    var typingTimerStMasterSearch; // Timer identifier StMaster Search
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("parts_name_master_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerPartsNameMasterSearch);
        typingTimerPartsNameMasterSearch = setTimeout(doneTypingLoadSt, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("parts_name_master_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerPartsNameMasterSearch);
    });

    // On keyup, start the countdown
    document.getElementById("st_master_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerStMasterSearch);
        typingTimerStMasterSearch = setTimeout(doneTypingLoadSt, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("st_master_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerStMasterSearch);
    });

    // User is "finished typing," do something
    const doneTypingLoadSt = () => {
        load_st(1);
    }

    // Table Responsive Scroll Event for Load More
    document.getElementById("list_of_st_res").addEventListener("scroll", () => {
        var scrollTop = document.getElementById("list_of_st_res").scrollTop;
        var scrollHeight = document.getElementById("list_of_st_res").scrollHeight;
        var offsetHeight = document.getElementById("list_of_st_res").offsetHeight;

        //check if the scroll reached the bottom
        if ((offsetHeight + scrollTop + 1) >= scrollHeight) {
            get_next_page();
        }
    });

    const get_next_page = () => {
        var current_page = parseInt(sessionStorage.getItem('list_of_st_table_pagination'));
        let total = sessionStorage.getItem('count_rows');
        var last_page = parseInt(sessionStorage.getItem('last_page'));
        var next_page = current_page + 1;
        if (next_page <= last_page && total > 0) {
            load_st(next_page);
        }
    }

    const count_st_list = () => {
        var parts_name = sessionStorage.getItem('parts_name_master_search');
        var st = sessionStorage.getItem('st_master_search');
        $.ajax({
            url: '../process/st/st_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'count_st_list',
                parts_name: parts_name,
                st: st
            },
            success: function (response) {
                sessionStorage.setItem('count_rows', response);
                var count = `Total: ${response}`;
                document.getElementById("list_of_st_info").innerHTML = count;

                if (response > 0) {
                    load_st_last_page();
                } else {
                    document.getElementById("btnNextPage").style.display = "none";
                    document.getElementById("btnNextPage").setAttribute('disabled', true);
                }
            }
        });
    }

    const load_st_last_page = () => {
        var parts_name = sessionStorage.getItem('parts_name_master_search');
        var st = sessionStorage.getItem('st_master_search');
        var current_page = parseInt(sessionStorage.getItem('list_of_st_table_pagination'));
        $.ajax({
            url: '../process/st/st_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'st_list_last_page',
                parts_name: parts_name,
                st: st
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

    const load_st = current_page => {
        // If an AJAX call is already in progress, return immediately
        if (load_st_ajax_in_process) {
            return;
        }

        var parts_name = document.getElementById('parts_name_master_search').value;
        var st = document.getElementById('st_master_search').value;

        var parts_name1 = sessionStorage.getItem('parts_name_master_search');
        var st1 = sessionStorage.getItem('st_master_search');

        if (current_page > 1) {
            switch (true) {
                case parts_name !== parts_name1:
                case st !== st1:
                    parts_name = parts_name1;
                    st = st1;
                    break;
                default:
            }
        } else {
            sessionStorage.setItem('parts_name_master_search', parts_name);
            sessionStorage.setItem('st_master_search', st);
        }

        // Set the flag to true as we're starting an AJAX call
        load_st_ajax_in_process = true;

        $.ajax({
            url: '../process/st/st_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'st_list',
                parts_name: parts_name,
                st: st,
                current_page: current_page
            },
            beforeSend: (jqXHR, settings) => {
                document.getElementById("btnNextPage").setAttribute('disabled', true);
                var loading = `<tr id="loading"><td colspan="8" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                if (current_page == 1) {
                    document.getElementById("list_of_st").innerHTML = loading;
                } else {
                    $('#list_of_st_table tbody').append(loading);
                }
                jqXHR.url = settings.url;
                jqXHR.type = settings.type;
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("btnNextPage").removeAttribute('disabled');
                if (current_page == 1) {
                    $('#list_of_st_table tbody').html(response);
                } else {
                    $('#list_of_st_table tbody').append(response);
                }
                sessionStorage.setItem('list_of_st_table_pagination', current_page);
                count_st_list();
                // Set the flag back to false as the AJAX call has completed
                load_st_ajax_in_process = false;
            }
        }).fail((jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR);
            console.log(`System Error : Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`);
            $('#loading').remove();
            document.getElementById("btnNextPage").removeAttribute('disabled');
            // Set the flag back to false as the AJAX call has completed
            load_st_ajax_in_process = false;
        });
    }

    $("#new_st").on('hidden.bs.modal', e => {
        document.getElementById('parts_name_master').value = '';
        document.getElementById('st_master').value = '';
    });

    document.getElementById('new_st_form').addEventListener('submit', e => {
        e.preventDefault();
        add_st();
    });

    const add_st = () => {
        var parts_name = document.getElementById('parts_name_master').value;
        var st = document.getElementById('st_master').value;

        $.ajax({
            url: '../process/st/st_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_st',
                parts_name: parts_name,
                st: st
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    document.getElementById('parts_name_master').value = '';
                    document.getElementById('st_master').value = '';
                    load_st(1);
                    $('#new_st').modal('hide');
                } else if (response == 'Already Exist') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Duplicate Data !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    const get_st_details = (param) => {
        var string = param.split('~!~');
        var id = string[0];
        var parts_name = string[1];
        var st = string[2];

        document.getElementById('id_st_master_update').value = id;
        document.getElementById('parts_name_master_update').value = parts_name;
        document.getElementById('st_master_update').value = st;
    }

    // Get the form element
    var update_st_form = document.getElementById('update_st_form');

    // Add a submit event listener to the form
    update_st_form.addEventListener('submit', e => {
        e.preventDefault();

        // Get the button that triggered the submit event
        var button = document.activeElement;

        // Check the id or name of the button
        if (button.id === 'btnUpdateSt') {
            // Call the function for the first submit button
            update_st();
        } else if (button.id === 'btnDeleteSt') {
            // Call the function for the first submit button
            delete_st();
        }
    });

    const update_st = () => {
        var id = document.getElementById('id_st_master_update').value;
        var parts_name = document.getElementById('parts_name_master_update').value;
        var st = document.getElementById('st_master_update').value;

        $.ajax({
            url: '../process/st/st_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_st',
                id: id,
                parts_name: parts_name,
                st: st
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    document.getElementById('id_st_master_update').value = '';
                    document.getElementById('parts_name_master_update').value = '';
                    document.getElementById('st_master_update').value = '';
                    load_st(1);
                    $('#update_st').modal('hide');
                } else if (response == 'Already Exist') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Duplicate Data !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    const delete_st = () => {
        var id = document.getElementById('id_st_master_update').value;
        $.ajax({
            url: '../process/st/st_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_st',
                id: id
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Succesfully Deleted !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    document.getElementById('id_st_master_update').value = '';
                    document.getElementById('parts_name_master_update').value = '';
                    document.getElementById('st_master_update').value = '';
                    load_st(1);
                    $('#update_st').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    const print_employees = () => {
        var parts_name = sessionStorage.getItem('parts_name_master_search');
        var st = sessionStorage.getItem('st_master_search');
        window.open('../process/print/print_employees_hr.php?parts_name=' + parts_name + "&st=" + st, '_blank');
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
            document.getElementById("count_delete_st_selected").innerHTML = `${numberOfChecked} ST Row/s Selected`;
            document.getElementById("btnDeleteSelected").removeAttribute('disabled');
        } else {
            document.getElementById("btnDeleteSelected").setAttribute('disabled', true);
        }
    }

    const export_st = () => {
        var parts_name = sessionStorage.getItem('parts_name_master_search');
        var st = sessionStorage.getItem('st_master_search');
        window.open('../process/export/exp_st.php?parts_name=' + parts_name + "&st=" + st, '_blank');
    }

    const delete_st_selected = () => {
        var arr = [];
        document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
            arr.push(el.value);
        });
        console.log(arr);
        var numberOfChecked = arr.length;
        if (numberOfChecked > 0) {
            id_arr = Object.values(arr);
            $.ajax({
                url: '../process/st/st_p.php',
                type: 'POST',
                cache: false,
                data: {
                    method: 'delete_st_selected',
                    id_arr: id_arr
                }, success: function (response) {
                    if (response == 'success') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Succesfully Deleted !!!',
                            text: 'Information',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        load_st(1);
                        document.getElementById("btnDeleteSelected").setAttribute('disabled', true);
                        $('#confirm_delete_st_selected').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!!',
                            text: 'Error',
                            showConfirmButton: false,
                            timer: 2000
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

    const print_st = () => {
        var parts_name = sessionStorage.getItem('parts_name_master_search');
        var st = sessionStorage.getItem('st_master_search');
        window.open('../process/print/print_st.php?parts_name=' + parts_name + "&st=" + st, '_blank');
    }

    const upload_csv = () => {
        var file_form = document.getElementById('file_form');
        var form_data = new FormData(file_form);
        $.ajax({
            url: '../process/import/imp_st.php',
            type: 'POST',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            beforeSend: (jqXHR, settings) => {
                Swal.fire({
                    icon: 'info',
                    title: 'Uploading Please Wait...',
                    text: 'Info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false
                });
                jqXHR.url = settings.url;
                jqXHR.type = settings.type;
            },
            success: response => {
                setTimeout(() => {
                    swal.close();
                    if (response != '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload CSV Error',
                            text: `Error: ${response}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Upload CSV',
                            text: 'Uploaded and updated successfully',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        load_st(1);
                    }
                    document.getElementById("file").value = '';
                }, 500);
            }
        })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.log(jqXHR);
                swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
            });
    }
</script>