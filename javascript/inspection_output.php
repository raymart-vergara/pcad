<script type="text/javascript">
         const get_inspection_list = () => {
                $.ajax({
                        url: 'process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_inspection_list'
                        },
                        success: function (response) {
                                $('#inspection_process_list').html(response);
                                $('#spinner').fadeOut();
                        }
                })
        }

        const get_overall_inspection = () => {
                $.ajax({
                        url: 'process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_overall_inspection'
                        },
                        success: function (response) {
                                try {
                                        let response_array = JSON.parse(response);
                                        if (response_array.message == 'success') {
                                                document.getElementById('insp_overall_g').innerHTML = response_array.insp_overall_g;
                                                document.getElementById('insp_overall_ng').innerHTML = response_array.insp_overall_ng;
                                        }
                                        else {
                                                console.log(response);
                                        }
                                } catch (e) {
                                        console.log(response);
                                }
                        }
                });
        }
</script>