<script type="text/javascript">
    const count_emp = () => {
        let dept_pd = document.getElementById('dept_pd').value;
        let dept_qa = document.getElementById('dept_qa').value;
        let section_pd = document.getElementById('section_pd').value;
        let section_qa = document.getElementById('section_qa').value;
        let line_no = document.getElementById('line_no').value;
        $.ajax({
            url: 'process/emp_mgt/emp_mgt_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'count_emp',
                dept_pd: dept_pd,
                dept_qa: dept_qa,
                section_pd: section_pd,
                section_qa: section_qa,
                line_no: line_no
            },
            success: function (response) {
                try {
                    let response_array = JSON.parse(response);
                    if (response_array.message == 'success') {
                        document.getElementById('total_pd_mp').innerHTML = response_array.total_pd_mp;
                        document.getElementById('total_present_pd_mp').innerHTML = response_array.total_present_pd_mp;
                        document.getElementById('total_absent_pd_mp').innerHTML = response_array.total_absent_pd_mp;
                        document.getElementById('total_pd_mp_line_support_to').innerHTML = response_array.total_pd_mp_line_support_to;
                        document.getElementById('absent_ratio_pd_mp').innerHTML = `${response_array.absent_ratio_pd_mp}%`;

                        document.getElementById('total_qa_mp').innerHTML = response_array.total_qa_mp;
                        document.getElementById('total_present_qa_mp').innerHTML = response_array.total_present_qa_mp;
                        document.getElementById('total_absent_qa_mp').innerHTML = response_array.total_absent_qa_mp;
                        document.getElementById('total_qa_mp_line_support_to').innerHTML = response_array.total_qa_mp_line_support_to;
                        document.getElementById('absent_ratio_qa_mp').innerHTML = `${response_array.absent_ratio_qa_mp}%`;
                    } else {
                        console.log(response);
                    }
                } catch (e) {
                    console.log(response);
                }
            }
        });
    }
</script>