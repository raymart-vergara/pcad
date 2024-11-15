<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_line_no_history_datalist_search();
    });

    const get_line_no_history_datalist_search = () => {
        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_line_no_history_datalist_search',
            },
            success: function (response) {
                document.getElementById("assy_history_line_no_list").innerHTML = response;
            }
        });
    }

    const get_assy_history = () => {
        let date_from = document.getElementById("assy_history_date_from_search").value;
        let date_to = document.getElementById("assy_history_date_to_search").value;
        let line_no = document.getElementById("assy_history_line_no_search").value;
        let nameplate_value = document.getElementById("assy_history_nameplate_value_search").value;
        let product_name = document.getElementById("assy_history_product_name_search").value;
        let lot_no = document.getElementById("assy_history_lot_no_search").value;
        let serial_no = document.getElementById("assy_history_serial_no_search").value;

        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_assy_history',
                date_from: date_from,
                date_to: date_to,
                line_no: line_no,
                nameplate_value: nameplate_value,
                product_name: product_name,
                lot_no: lot_no,
                serial_no: serial_no
            },
            beforeSend: () => {
                var loading = `<tr id="loading"><td colspan="9" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                document.getElementById("assyHistoryData").innerHTML = loading;
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("assyHistoryData").innerHTML = response;
                sessionStorage.setItem('pcad_assy_history_date_from_search', date_from);
                sessionStorage.setItem('pcad_assy_history_date_to_search', date_to);
                sessionStorage.setItem('pcad_assy_history_line_no_search', line_no);
                sessionStorage.setItem('pcad_assy_history_nameplate_value_search', nameplate_value);
                sessionStorage.setItem('pcad_assy_history_product_name_search', product_name);
                sessionStorage.setItem('pcad_assy_history_lot_no_search', lot_no);
                sessionStorage.setItem('pcad_assy_history_serial_no_search', serial_no);
            }
        });
    }

    let isProcessing = false; // Flag to prevent multiple calls

    document.getElementById('assy_history_form').addEventListener('submit', e => {
        e.preventDefault();
        get_assy_history();
        document.getElementById("assy_history_nameplate_value_search").value = '';
    });

    document.getElementById("assy_history_nameplate_value_search").addEventListener("change", e => {
        e.preventDefault();
        e.stopPropagation(); // Prevent the event from bubbling up

        if (!isProcessing) {
            isProcessing = true; // Set the flag to true
            get_assy_history();
            document.getElementById("assy_history_nameplate_value_search").value = '';
            isProcessing = false; // Reset the flag after processing
        }
    });

    document.getElementById("assy_history_nameplate_value_search").addEventListener("keydown", e => {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent form submission on Enter key
            e.stopPropagation(); // Prevent the event from bubbling up

            if (!isProcessing) {
                isProcessing = true; // Set the flag to true
                get_assy_history();
                document.getElementById("assy_history_nameplate_value_search").value = '';
                isProcessing = false; // Reset the flag after processing
            }
        }
    });

    const export_assy_history = (table_id, separator = ',') => {
        let date_from = sessionStorage.getItem('pcad_assy_history_date_from_search');
        let date_to = sessionStorage.getItem('pcad_assy_history_date_to_search');
        let line_no = sessionStorage.getItem('pcad_assy_history_line_no_search');
        let nameplate_value = sessionStorage.getItem("pcad_assy_history_nameplate_value_search");
        let product_name = sessionStorage.getItem("pcad_assy_history_product_name_search");
        let lot_no = sessionStorage.getItem("pcad_assy_history_lot_no_search");
        let serial_no = sessionStorage.getItem("pcad_assy_history_serial_no_search");

        // Select rows from table_id
        var rows = document.querySelectorAll('table#' + table_id + ' tr');

        // Construct csv
        var csv = [];
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll('td, th');
            for (var j = 0; j < cols.length; j++) {
                var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                data = data.replace(/"/g, '""');
                // Push escaped string
                row.push('"' + data + '"');
            }
            csv.push(row.join(separator));
        }

        var csv_string = csv.join('\n');

        // Download it
        var filename = 'PCAD_AssemblyProcessHistory';
		if (line_no) {
			filename += '_' + line_no;
		}
        if (date_from) {
			filename += '_' + date_from;
		}
        if (date_to) {
			filename += '_' + date_to;
		}
        if (product_name) {
			filename += '_' + product_name;
		}
        if (lot_no) {
			filename += '_' + lot_no;
		}
        if (serial_no) {
			filename += '_' + serial_no;
		}
		filename += '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>