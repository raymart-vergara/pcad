<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_car_maker();
        get_product_no_datalist_search();
        get_lot_no_datalist_search();
        get_serial_no_datalist_search();
        get_recent_assy_in();
    });

    const get_car_maker = () => {
        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_car_maker',
            },
            success: function (response) {
                document.getElementById("assy_in_car_maker").innerHTML = response;
            }
        });
    }

    const get_product_no_datalist_search = () => {
        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_product_no_datalist_search',
            },
            success: function (response) {
                document.getElementById("assy_page_product_name_list").innerHTML = response;
            }
        });
    }

    const get_lot_no_datalist_search = () => {
        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_lot_no_datalist_search',
            },
            success: function (response) {
                document.getElementById("assy_page_lot_no_list").innerHTML = response;
            }
        });
    }

    const get_serial_no_datalist_search = () => {
        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_serial_no_datalist_search',
            },
            success: function (response) {
                document.getElementById("assy_page_serial_no_list").innerHTML = response;
            }
        });
    }

    const get_recent_assy_in = () => {
        let line_no = document.getElementById("assy_page_line_no_search").value;
        let nameplate_value = document.getElementById("assy_page_nameplate_value_search").value;
        let product_name = document.getElementById("assy_page_product_name_search").value;
        let lot_no = document.getElementById("assy_page_lot_no_search").value;
        let serial_no = document.getElementById("assy_page_serial_no_search").value;

        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_recent_assy_in',
                line_no: line_no,
                nameplate_value: nameplate_value,
                product_name: product_name,
                lot_no: lot_no,
                serial_no: serial_no
            },
            beforeSend: () => {
                var loading = `<tr id="loading"><td colspan="8" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                document.getElementById("assyInData").innerHTML = loading;
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("assyInData").innerHTML = response;
                sessionStorage.setItem('pcad_assy_page_line_no_search', line_no);
                sessionStorage.setItem('pcad_assy_page_nameplate_value_search', nameplate_value);
                sessionStorage.setItem('pcad_assy_page_product_name_search', product_name);
                sessionStorage.setItem('pcad_assy_page_lot_no_search', lot_no);
                sessionStorage.setItem('pcad_assy_page_serial_no_search', serial_no);
            }
        });
    }

    document.getElementById("assy_page_nameplate_value_search").addEventListener("change", e => {
		e.preventDefault();
        get_recent_assy_in();
        document.getElementById("assy_page_nameplate_value_search").value = '';
	});

    var typingTimerAssyPageProductNameSearch;
	var typingTimerAssyPageLotNoSearch;
    var typingTimerAssyPageSerialNoSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("assy_page_product_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAssyPageProductNameSearch);
        typingTimerAssyPageProductNameSearch = setTimeout(doneTypingGetRecentAssyIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("assy_page_product_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAssyPageProductNameSearch);
    });

	// On keyup, start the countdown
    document.getElementById("assy_page_lot_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAssyPageLotNoSearch);
        typingTimerAssyPageLotNoSearch = setTimeout(doneTypingGetRecentAssyIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("assy_page_lot_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAssyPageLotNoSearch);
    });

    // On keyup, start the countdown
    document.getElementById("assy_page_serial_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAssyPageSerialNoSearch);
        typingTimerAssyPageSerialNoSearch = setTimeout(doneTypingGetRecentAssyIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("assy_page_serial_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAssyPageSerialNoSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentAssyIn = () => {
        get_recent_assy_in();
    }

    const export_recent_assy_in = (table_id, separator = ',') => {
        let line_no = sessionStorage.getItem('pcad_assy_page_line_no_search');
        let nameplate_value = sessionStorage.getItem("pcad_assy_page_nameplate_value_search");
        let product_name = sessionStorage.getItem("pcad_assy_page_product_name_search");
        let lot_no = sessionStorage.getItem("pcad_assy_page_lot_no_search");
        let serial_no = sessionStorage.getItem("pcad_assy_page_serial_no_search");

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
        var filename = 'PCAD_OngoingAssemblyProcess';
		if (line_no) {
			filename += '_' + line_no;
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
		filename += '_' + new Date().toJSON().slice(0, 10) + '.csv';
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