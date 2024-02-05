<!-- <script>
	$(document).ready(function(){
		$(document).on('click', '.btn-clear', function(){
			localStorage.setItem("line_no", null);
			window.open("setting.php","_self");
		});
		if (localStorage.getItem("line_no") === null) {
		  localStorage.setItem("line_no", null);
		}else{
		  $("#b").val(localStorage.getItem("line_no"));
		}
		if($("#b").val() != "null"){
			$.post('process/setting_p.php',{
				line_no : 'getLineName',
				line_no: $("#b").val()
			}, function(response){
				// console.log(response);
				$("#b").val(response.trim());
			});
		}
		$(document).on('change', '#a', function(){
			localStorage.setItem("line_no", $("#a").val());
		  	$("#b").val(localStorage.getItem("line_no"));
		  	location.reload();
		});

		// ADVANCE LISTENER -----------------------------------------------------
		document.addEventListener("keypress",function(e){
			if(e.keyCode == 49 || e.keyCode == 97){
				localStorage.setItem("line_no", null);
				window.open("setting.php","_self");
			}
			if(e.keyCode == 48 || e.keyCode == 96){
				var url	= $('#mainMenu').prop('href');
				window.open(url,"_self");
			}
		});

	})
</script>
</body>
</html> -->
