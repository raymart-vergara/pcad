<script type="text/javascript">
    const count_emp = () => {
        let shift_group = document.getElementById('shift_group').value;
        let dept_pd = document.getElementById('dept_pd').value;
        let dept_qa = document.getElementById('dept_qa').value;
        let section_pd = document.getElementById('section_pd').value;
        let section_qa = document.getElementById('section_qa').value;
        let line_no = document.getElementById('line_no').value;
        let day = localStorage.getItem("pcad_prod_server_date_only");
        let shift = localStorage.getItem("shift");
        $.ajax({
            url: 'process/emp_mgt/emp_mgt_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'count_emp',
                shift_group: shift_group,
                dept_pd: dept_pd,
                dept_qa: dept_qa,
                section_pd: section_pd,
                section_qa: section_qa,
                line_no: line_no,
                day: day,
                shift: shift,
                opt: 1
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

    const get_process_design = () => {
        let registlinename = document.getElementById('registlinename').value;
        let shift_group = document.getElementById('shift_group').value;
        let line_no = document.getElementById('line_no').value;
        let day = localStorage.getItem("pcad_prod_server_date_only");
        $.ajax({
            url: 'process/emp_mgt/emp_mgt_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_process_design',
                registlinename: registlinename,
                shift_group: shift_group,
                line_no: line_no,
                day: day,
                opt: 1
            },
            success: function (response) {
                document.getElementById('process_design_data').innerHTML = response;
            }
        });
    }

    // const get_absent_employees = () => {
    //     let shift_group = document.getElementById('shift_group').value;
    //     let line_no = document.getElementById('line_no').value;
    //     $.ajax({
    //         url: 'process/emp_mgt/emp_mgt_p.php',
    //         type: 'GET',
    //         cache: false,
    //         data: {
    //             method: 'get_absent_employees',
    //             shift_group: shift_group,
    //             line_no: line_no
    //         },
    //         success: function (response) {
    //             document.getElementById('absent_employees_data').innerHTML = response;
    //         }
    //     });
    // }

    const get_present_employees = () => {
        let shift_group = document.getElementById('shift_group').value;
        let line_no = document.getElementById('line_no').value;

        $.ajax({
            url: 'process/emp_mgt/emp_mgt_p.php',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                method: 'get_present_employees',
                shift_group: shift_group,
                line_no: line_no
            },
            success: function (response) {
                console.log("Raw response:", response); // Debugging

                if (!response || typeof response !== "object") {
                    console.error("Invalid JSON format received:", response);
                    return;
                }

                const gridContainer = document.getElementById('present_employees_grid');
                gridContainer.innerHTML = ''; // Clear previous content

                for (const process in response) {
                    if (response.hasOwnProperty(process)) {
                        // Create a container row
                        const rowDiv = document.createElement('div');
                        rowDiv.className = 'd-flex align-items-start';
                        rowDiv.style.borderTop = "1px solid #FFF";
                        // rowDiv.style.borderBottom = "1px solid #FFF";
                        rowDiv.style.padding = "20px";
                        rowDiv.style.background = 'rgba(0, 0, 0, 0.50)';

                        // First Column: Process Name
                        const processCol = document.createElement('div');
                        processCol.className = 'process-name';
                        processCol.style.fontWeight = 'bold';
                        processCol.style.fontSize = '30px';
                        processCol.style.textAlign = 'right';
                        processCol.style.width = '25%';
                        processCol.style.paddingRight = '20px';
                        processCol.textContent = process;

                        // Second Column: Employees List
                        const employeesCol = document.createElement('div');
                        employeesCol.className = 'employees-list d-flex flex-wrap';
                        employeesCol.style.width = '75%';

                        response[process].forEach(employee => {
                            const employeeDiv = document.createElement('div');
                            employeeDiv.className = 'employee-card d-flex flex-column align-items-center text-center';
                            employeeDiv.style.borderRadius = '8px';
                            employeeDiv.style.padding = '5px';
                            employeeDiv.style.margin = '5px';
                            employeeDiv.style.width = '140px';

                            // ✅ Set Background Color Based on Presence
                            if (employee.status === 'present') {
                                employeeDiv.style.background = '#FFF'; // White for present
                                // employeeDiv.style.color = '#FFF';
                            } else {
                                employeeDiv.style.background = '#DC4E4E'; //  red for absent
                                employeeDiv.style.color = '#FFF';
                            }

                            // Image
                            const img = document.createElement('img');
                            img.src = employee.file_url;
                            img.alt = employee.emp_no;
                            img.style.width = '80px';
                            img.style.height = '80px';
                            img.style.objectFit = 'cover';
                            img.style.marginBottom = '10px';
                            img.setAttribute('loading', 'lazy'); // Add lazy loading

                            // Name
                            const nameDiv = document.createElement('div');
                            nameDiv.className = 'employee-name';
                            nameDiv.style.fontWeight = 'bold';
                            nameDiv.style.fontSize = '13px';
                            nameDiv.style.marginTop = '5px';
                            nameDiv.textContent = employee.full_name;

                            // Append elements
                            employeeDiv.appendChild(img);
                            employeeDiv.appendChild(nameDiv);
                            employeesCol.appendChild(employeeDiv);
                        });

                        // Append to row
                        rowDiv.appendChild(processCol);
                        rowDiv.appendChild(employeesCol);

                        // Append row to grid container
                        gridContainer.appendChild(rowDiv);
                    }
                }
                startAutoScrollGrid();
                adjustGridItemsHeight();
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    };

    // Function to dynamically adjust the height of grid items based on the number of items
    const adjustGridItemsHeight = () => {
        const gridContainer = document.getElementById('present_employees_grid');
        const itemCount = gridContainer.childElementCount;
        const containerHeight = 650;
        const rowCount = Math.ceil(itemCount / 4);
        const rowHeight = containerHeight / rowCount;

        if (rowHeight < 150) {
            gridContainer.style.gridAutoRows = '150px';
        } else {
            gridContainer.style.gridAutoRows = `${rowHeight}px`;
        }
    };

    const get_absent_employees = () => {
        let shift_group = document.getElementById('shift_group').value;
        let line_no = document.getElementById('line_no').value;

        $.ajax({
            url: 'process/emp_mgt/emp_mgt_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_absent_employees',
                shift_group: shift_group,
                line_no: line_no
            },
            success: function (response) {
                const gridContainer = document.getElementById('absent_employees_grid');
                gridContainer.innerHTML = response;

                adjustGridItemsHeightAbsent(); // Adjust item height based on the total number of items
            }
        });
    };

    const adjustGridItemsHeightAbsent = () => {
        const gridContainer = document.getElementById('absent_employees_grid');
        const itemCount = gridContainer.childElementCount; // Get the number of grid items
        const containerHeight = 650; // Carousel container height
        const rowCount = Math.ceil(itemCount / 4); // 4 items per row (adjust if necessary)
        const rowHeight = containerHeight / rowCount; // Calculate height per row

        // Ensure the items fill the available height of the container
        if (rowHeight < 150) {
            gridContainer.style.gridAutoRows = '150px'; // Set a minimum row height of 150px if calculated height is too small
        } else {
            gridContainer.style.gridAutoRows = `${rowHeight}px`; // Set height per row dynamically
        }
    };

</script>