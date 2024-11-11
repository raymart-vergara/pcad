<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_car_maker();
        // get_recent_assy_in();
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
                document.getElementById("assy_out_car_maker").innerHTML = response;
            }
        });
    }

    const get_recent_assy_in = () => {
        let line_no = document.getElementById("assy_page_line_no").value;

        $.ajax({
            url: '../process/assy/assy_g_p.php',
            type: 'GET',
            cache: false,
            data: {
                method: 'get_recent_assy_in',
                line_no: line_no
            },
            beforeSend: () => {
                var loading = `<tr id="loading"><td colspan="8" style="text-align:center;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></td></tr>`;
                document.getElementById("assyInData").innerHTML = loading;
            },
            success: function (response) {
                $('#loading').remove();
                document.getElementById("assyInData").innerHTML = response;
                sessionStorage.setItem('pcad_assy_page_line_no_search', line_no);
            }
        });
    }

    const export_hourly_output = () => {
        let registlinename = sessionStorage.getItem('line_no_search');
        let line_no = localStorage.getItem("pcad_line_no");
        let hourly_output_date = sessionStorage.getItem('hourly_output_date_search');
        let shift = sessionStorage.getItem('shift_search');
        let target_output = sessionStorage.getItem('target_output_search');
        window.open('../process/export/exp_hourly_output.php?registlinename=' + registlinename + '&line_no=' + line_no + "&shift=" + shift + "&target_output=" + target_output + "&hourly_output_date=" + hourly_output_date, '_blank');
    }

    document.getElementById("assy_in_car_maker").addEventListener("change", e => {
        let car_maker = document.getElementById("assy_in_car_maker").value;

        if (car_maker) {
            $.ajax({
                url: '../process/assy/assy_g_p.php',
                type: 'GET',
                cache: false,
                data: {
                    method: 'get_car_model',
                    car_maker: car_maker
                },
                success: function (response) {
                    document.getElementById("assy_in_car_model").innerHTML = response;
                    document.getElementById("assy_in_car_model").disabled = false;
                    document.getElementById("assy_in_nameplate_value").value = '';
                    document.getElementById("assy_in_nameplate_value").disabled = true;
                }
            });
        } else {
            document.getElementById("assy_in_car_model").innerHTML = '<option></option>';
            document.getElementById("assy_in_nameplate_value").disabled = true;
        }
    });

    document.getElementById("assy_out_car_maker").addEventListener("change", e => {
        let car_maker = document.getElementById("assy_out_car_maker").value;

        if (car_maker) {
            $.ajax({
                url: '../process/assy/assy_g_p.php',
                type: 'GET',
                cache: false,
                data: {
                    method: 'get_car_model',
                    car_maker: car_maker
                },
                success: function (response) {
                    document.getElementById("assy_out_car_model").innerHTML = response;
                    document.getElementById("assy_out_car_model").disabled = false;
                    document.getElementById("assy_out_nameplate_value").value = '';
                    document.getElementById("assy_out_nameplate_value").disabled = true;
                }
            });
        } else {
            document.getElementById("assy_out_car_model").innerHTML = '<option></option>';
            document.getElementById("assy_out_nameplate_value").disabled = true;
        }
    });

    document.getElementById("assy_in_car_model").addEventListener("change", e => {
        let car_model = document.getElementById("assy_in_car_model").value;

        if (car_model) {
            $.ajax({
                url: '../process/assy/assy_g_p.php',
                type: 'GET',
                cache: false,
                data: {
                    method: 'get_nameplate_config',
                    car_model: car_model
                },
                success: function (response) {
                    const nameplate_config = JSON.parse(response);
                    if (nameplate_config && Object.keys(nameplate_config).length > 0) {
                        window.nameplateConfig = nameplate_config;
                        document.getElementById("assy_in_nameplate_value").disabled = false;
                        document.getElementById("assy_in_nameplate_value").focus();
                    } else {
                        document.getElementById("assy_in_nameplate_value").disabled = true;
                    }
                }
            });
        } else {
            document.getElementById("assy_in_nameplate_value").disabled = true;
        }
    });

    document.getElementById("assy_out_car_model").addEventListener("change", e => {
        let car_model = document.getElementById("assy_out_car_model").value;

        if (car_model) {
            $.ajax({
                url: '../process/assy/assy_g_p.php',
                type: 'GET',
                cache: false,
                data: {
                    method: 'get_nameplate_config',
                    car_model: car_model
                },
                success: function (response) {
                    const nameplate_config = JSON.parse(response);
                    if (nameplate_config && Object.keys(nameplate_config).length > 0) {
                        window.nameplateConfig2 = nameplate_config;
                        document.getElementById("assy_out_nameplate_value").disabled = false;
                        document.getElementById("assy_out_nameplate_value").focus();
                    } else {
                        document.getElementById("assy_out_nameplate_value").disabled = true;
                    }
                }
            });
        } else {
            document.getElementById("assy_out_nameplate_value").disabled = true;
        }
    });

    const display_assy_in_out_result = (id, type, message) => {
		var duration = 0;
		var error_message = 'Error: ';
		if (type == 'error') {
			duration = 5000;
			message = error_message + message;
			document.getElementById(id).classList.add('text-red');
		} else {
			duration = 3000;
		}
		document.getElementById(id).innerHTML = message;
		setTimeout(() => {
			document.getElementById(id).innerHTML = '';
			document.getElementById(id).classList.remove('text-red');
		}, duration);
	}

    const reset_assy_in_fields = () => {
		document.getElementById("assy_in_nameplate_value").value = '';
		document.getElementById("assy_in_nameplate_value").disabled = false;
		document.getElementById("assy_in_nameplate_value").focus();
	}

    const reset_assy_out_fields = () => {
		document.getElementById("assy_out_nameplate_value").value = '';
		document.getElementById("assy_out_nameplate_value").disabled = false;
		document.getElementById("assy_out_nameplate_value").focus();
	}

    // Assy In
    document.getElementById("assy_in_nameplate_value").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("assy_in_nameplate_value").disabled = true;
        let result = check_nameplate_value(e.target.value, 1);
        if (result == '') {
            assy_in();
        } else {
            display_assy_in_out_result('in_assy_result', 'error', result);
            reset_assy_in_fields();
        }
	});

    // Assy Out
    document.getElementById("assy_out_nameplate_value").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("assy_out_nameplate_value").disabled = true;
        let result = check_nameplate_value(e.target.value, 2);
        if (result == '') {
            assy_out();
        } else {
            display_assy_in_out_result('out_assy_result', 'error', result);
            reset_assy_out_fields();
        }
	});

    const check_nameplate_value = (nameplate_value, opt) => {
        // console.log('QR Code:', nameplate_value);

        let config = '';

        if (opt == 1) {
            config = window.nameplateConfig;
        } else if (opt == 2) {
            config = window.nameplateConfig2;
        }

        if (config) {
            var totalLength = parseInt(config.total_length, 10);
            var productNameStart = parseInt(config.product_name_start, 10);
            var productNameLength = parseInt(config.product_name_length, 10);
            var lotNoStart = parseInt(config.lot_no_start, 10);
            var lotNoLength = parseInt(config.lot_no_length, 10);
            var serialNoStart = parseInt(config.serial_no_start, 10);
            var serialNoLength = parseInt(config.serial_no_length, 10);

            // console.log('Parsed Config:', {
            //     totalLength,
            //     productNameStart,
            //     productNameLength,
            //     lotNoStart,
            //     lotNoLength,
            //     serialNoStart,
            //     serialNoLength
            // });
            // console.log('Expected Length:', totalLength);
            // console.log('QR Code Length:', nameplate_value.length);

            if (nameplate_value.length === totalLength) {
                var productName = nameplate_value.substring(productNameStart, productNameStart + productNameLength).trim();
                var lotNo = nameplate_value.substring(lotNoStart, lotNoStart + lotNoLength).trim();
                var serialNo = nameplate_value.substring(serialNoStart, serialNoStart + serialNoLength).trim();

                // console.log('Product Name:', productName);
                // console.log('Lot No:', lotNo);
                // console.log('Serial No:', serialNo);

                if (opt == 1) {
                    document.getElementById('assy_in_product_name').value = productName;
                    document.getElementById('assy_in_lot_no').value = lotNo;
                    document.getElementById('assy_in_serial_no').value = serialNo;
                } else if (opt == 2) {
                    document.getElementById('assy_out_product_name').value = productName;
                    document.getElementById('assy_out_lot_no').value = lotNo;
                    document.getElementById('assy_out_serial_no').value = serialNo;
                }

                return;
            } else {
                console.error("QR code length does not match expected length. Expected:", totalLength, " Actual:", nameplate_value.length);
                return "QR code length does not match expected length. Expected:" + totalLength + " Actual:" + nameplate_value.length;
            }
        } else {
            console.error("Nameplate Config was not available.");
            return "Nameplate Config was not available.";
        }
    }

    const assy_in = () => {
        let nameplate_value = document.getElementById("assy_in_nameplate_value").value;
        let car_maker = document.getElementById("assy_in_car_maker").value;
        let car_model = document.getElementById("assy_in_car_model").value;
        let line_no = document.getElementById("assy_page_line_no").value;
        let product_name = document.getElementById("assy_in_product_name").value;
        let lot_no = document.getElementById("assy_in_lot_no").value;
        let serial_no = document.getElementById("assy_in_serial_no").value;

        $.ajax({
            url: '../process/assy/assy_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'assy_in',
                nameplate_value: nameplate_value,
                car_maker: car_maker,
                car_model: car_model,
                line_no: line_no,
                product_name: product_name,
                lot_no: lot_no,
                serial_no: serial_no
            },
            success: function (response) {
                if (response == 'success') {
                    display_assy_in_out_result('in_assy_result', '', 'Assy In Succesfully!!!');
                    get_recent_assy_in();
                } else {
					display_assy_in_out_result('in_assy_result', 'error', response);
				}
                reset_assy_in_fields();
            }
        });
    }

    const assy_out = () => {
        let nameplate_value = document.getElementById("assy_out_nameplate_value").value;
        let car_maker = document.getElementById("assy_out_car_maker").value;
        let car_model = document.getElementById("assy_out_car_model").value;
        let line_no = document.getElementById("assy_page_line_no").value;
        let product_name = document.getElementById("assy_out_product_name").value;
        let lot_no = document.getElementById("assy_out_lot_no").value;
        let serial_no = document.getElementById("assy_out_serial_no").value;

        $.ajax({
            url: '../process/assy/assy_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'assy_out',
                nameplate_value: nameplate_value,
                car_maker: car_maker,
                car_model: car_model,
                line_no: line_no,
                product_name: product_name,
                lot_no: lot_no,
                serial_no: serial_no
            },
            success: function (response) {
                if (response == 'success') {
                    display_assy_in_out_result('out_assy_result', '', 'Assy Out Succesfully!!!');
                    get_recent_assy_in();
                } else {
					display_applicator_in_out_result('out_assy_result', 'error', response);
				}
                reset_assy_out_fields();
            }
        });
    }
</script>