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

                                                // document.getElementById('dimension_p').innerHTML = response_array.dimension_p;
                                                // document.getElementById('dimension_p_ng').innerHTML = response_array.dimension_p_ng;

                                                // document.getElementById('ect_p').innerHTML = response_array.ect_p;
                                                // document.getElementById('ect_p_ng').innerHTML = response_array.ect_p_ng;

                                                // document.getElementById('visual_p').innerHTML = response_array.visual_p;
                                                // document.getElementById('visual_p_ng').innerHTML = response_array.visual_p_ng;

                                                // document.getElementById('assurance_p').innerHTML = response_array.assurance_p;
                                                // document.getElementById('assurance_p_ng').innerHTML = response_array.assurance_p_ng;
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

        const get_specific_inspection_good = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_specific_inspection_good'
                        },
                        success: function (response) {
                                try {
                                        let response_array = JSON.parse(response);
                                        if (response_array.message === 'success') {
                                                const getElementById = (id) => document.getElementById(id);

                                                getElementById('dimension_p').innerHTML = response_array.dimension_p;
                                                getElementById('ect_p').innerHTML = response_array.ect_p;
                                                getElementById('visual_p').innerHTML = response_array.visual_p;
                                                getElementById('assurance_p').innerHTML = response_array.assurance_p;
                                        } else {
                                                console.error('Unexpected response:', response);
                                        }
                                } catch (e) {
                                        console.error('Error parsing JSON:', e);
                                        console.log('Actual response:', response);
                                }
                        }
                });
        };

        // const get_specific_inspection_no_good = () => {
        //         $.ajax({
        //                 url: '../process/inspection_output/inspection_output_p.php',
        //                 type: 'GET',
        //                 cache: false,
        //                 data: {
        //                         method: 'get_specific_inspection_no_good',
        //                 },
        //                 success: function (response) {
        //                         try {
        //                                 let response_array = JSON.parse(response);
        //                                 if (response_array.message === 'success') {
        //                                         const getElementById = (id) => document.getElementById(id);

        //                                         getElementById('dimension_p_ng').innerHTML = response_array.dimension_p_ng;
        //                                         getElementById('ect_p_ng').innerHTML = response_array.ect_p_ng;
        //                                         getElementById('visual_p_ng').innerHTML = response_array.visual_p_ng;
        //                                         getElementById('assurance_p_ng').innerHTML = response_array.assurance_p_ng;
        //                                 } else {
        //                                         console.error('Unexpected response:', response);
        //                                 }
        //                         } catch (e) {
        //                                 console.error('Error parsing JSON:', e);
        //                                 console.log('Actual response:', response);
        //                         }
        //                 }
        //         });
        // };

        const get_specific_inspection_no_good = () => {
                $.ajax({
                        url: '../process/inspection_output/inspection_output_p.php',
                        type: 'GET',
                        cache: false,
                        data: {
                                method: 'get_specific_inspection_no_good'
                        },
                        success: function (response) {
                                try {
                                        let response_array = JSON.parse(response);
                                        if (response_array.message === 'success') {
                                                const getElementById = (id) => document.getElementById(id);

                                                getElementById('dimension_p_ng').innerHTML = response_array.dimension_p_ng;
                                                getElementById('ect_p_ng').innerHTML = response_array.ect_p_ng;
                                                getElementById('visual_p_ng').innerHTML = response_array.visual_p_ng;
                                                getElementById('assurance_p_ng').innerHTML = response_array.assurance_p_ng;
                                        } else {
                                                console.error('Unexpected response:', response);
                                        }
                                } catch (e) {
                                        console.error('Error parsing JSON:', e);
                                        console.log('Actual response:', response);
                                }
                        }
                });
        };




</script>