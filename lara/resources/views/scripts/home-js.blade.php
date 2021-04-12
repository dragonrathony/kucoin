<script>
$(document).ready(function() {
    getCurrentPrice();

    function getCurrentPrice() {
        $.ajax({
            url: "{{url('home/getCurrentPrice')}}",
            success: function(res) {
                $('#current_price').html(res);
                setTimeout(getCurrentPrice, 15000);
            },
        });
    };
});
</script>