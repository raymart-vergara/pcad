<script>
$(document).ready(function(){
	    // Line
		if (localStorage.getItem("registlinename") === null) {
		  localStorage.setItem("registlinename", null);
		}else{
		  $("#line_no").val(localStorage.getItem("registlinename"));
		}
		if($("#line_no").val() != "null"){
			$.post('../process/pcs/setting_p.php',{
				request: 'getLineNo',
				registlinename: $("#line_no").val()
			}, function(response){
				console.log(response);
				$("#line_no").val(response.trim());
			});
		}

		$(document).on('change', '#ircs_line', function(){
			localStorage.setItem("registlinename", $("#ircs_line").val());
		  	$("#line_no").val(localStorage.getItem("registlinename"));
		  	location.reload();
		});

		//Plan
		$(document).on('keyup', '#plan', function(){
			getTakt();
		});

		$(document).on('keyup', '#secs', function(){
			getTakt();
		});
	});
		function getTakt(){
			var plan = $("#plan").val();
			var secs = $("#secs").val();
			var takt = secs / plan;
			$("#takt_time").val(takt.toFixed());

	}


</script>
</body>
</html> -
