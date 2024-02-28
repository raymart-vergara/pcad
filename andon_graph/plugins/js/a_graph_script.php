<script type="text/javascript">
    let chart; // Declare chart variable globally
    $(document).ready(function () {
        andon_detail();
    });

    const andon_detail = () =>{
        let andon_line ='DAIHATSU D92-2132'
        $.ajax({
            url: '../process/andon_graph/a_graph_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'andon_detail',
                andon_line:andon_line
            }, success: function (response) {
                $('#andon_details').html(response);
            }
        });

    }
</script>
