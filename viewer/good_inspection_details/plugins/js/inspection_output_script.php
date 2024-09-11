<script type="text/javascript">
    $(document).ready(function () {
        get_inspection_details_good();
    });

    const get_inspection_details_good = () => {
        let registlinename = localStorage.getItem("registlinename");
        let line_no = localStorage.getItem("pcad_line_no");
        let server_date_only = localStorage.getItem("pcad_exec_server_date_only");
        let shift = localStorage.getItem("shift");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));
        
        $.ajax({
            url: '../../process/inspection_output/inspection_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_inspection_details_good',
                registlinename: registlinename,
                line_no: line_no,
                server_date_only: server_date_only,
                shift: shift,
                opt: opt
            },
            success: function (response) {
                // Inject the HTML directly into the table
                $('#inspection_good_table').html(response);

                // Initialize DataTable
                $('#inspection_good_table').DataTable({
                    "scrollX": true
                });
                $('.dataTables_length').addClass('bs-select');
            }
        });
    }

    const export_good_record_viewer = () => {
        let registlinename = localStorage.getItem("registlinename");
        let line_no = localStorage.getItem("pcad_line_no");
        let server_date_only = localStorage.getItem("pcad_exec_server_date_only");
        let shift = localStorage.getItem("shift");
        let opt = parseInt(localStorage.getItem("pcad_exec_opt"));
        window.open('../../process/export/exp_good_insp.php?registlinename=' + registlinename + '&line_no=' + line_no + '&shift=' + shift + '&server_date_only=' + server_date_only + '&opt=' + opt, '_blank');
    }
</script>