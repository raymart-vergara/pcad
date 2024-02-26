<script type="text/javascript">
        const get_overall_inspection = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
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

                                                document.getElementById('dimension_p').innerHTML = response_array.dimension_p;
                                                document.getElementById('dimension_p_ng').innerHTML = response_array.dimension_p_ng;

                                                document.getElementById('ect_p').innerHTML = response_array.ect_p;
                                                document.getElementById('ect_p_ng').innerHTML = response_array.ect_p_ng;

                                                document.getElementById('assurance_p').innerHTML = response_array.assurance_p;
                                                document.getElementById('assurance_p_ng').innerHTML = response_array.assurance_p_ng;
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