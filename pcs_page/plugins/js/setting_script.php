<script>

function fetchIRCSDropdown() {
    $.ajax({
        url: 'process/setting_p.php', 
        method: 'POST',
        data:{ 
            method: 'fetch_ircs_line'
        },
        dataType: 'html',
        success: function(response) {
            $('#ircsDropdown').html(response);
        },
        error: function() {
            console.error('Error fetching data');
        }
    });
}

// Add change event handler for the dropdown
$('#ircsDropdown').on('change', function() {
    var selectedLineNo = $(this).val();

    if (selectedLineNo) {
        $.ajax({
            url: 'process/setting_p.php', 
            method: 'POST',
            data: { 
                method: 'getLineNo',
                registlinename: selectedLineNo
            },
            dataType: 'html',
            success: function(response) {
                $('#line_no').val(response);
            },
            error: function() {
                console.error('Error fetching line number');
            }
        });
    } else {
     
        $('#line_no').val('');
    }
});

fetchIRCSDropdown();


</script>
</body>
</html> -
