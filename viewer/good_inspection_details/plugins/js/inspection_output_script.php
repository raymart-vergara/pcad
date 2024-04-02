<script type="text/javascript">
    $(document).ready(function () {
        get_inspection_details_good();
    });

    const get_inspection_details_good = () => {
        let registlinename = localStorage.getItem("registlinename");
        
        $.ajax({
            url: '../../process/inspection_output/inspection_output_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_inspection_details_good',
                registlinename: registlinename
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
        window.open('../../process/export/exp_good_insp.php?registlinename=' + registlinename, '_blank');
    }
</script>