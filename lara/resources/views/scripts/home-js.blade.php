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

    getAvailableTransferAmount("TETHER", "MAIN");
});

function getAvailableTransferAmount(currency, type) {
    console.log("here")
    $.ajax({
        url: "{{url('home/getAvailableTransferAmount')}}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            data: {
                currency: currency,
                type: type,
            }
        },
        success: function(res) {
            console.log('ajax result...', res, typeof res);
            if (res.status) {
                $('#transfer_available').html(res.result);
                $('#error_msg').hide();
            } else {
                $('#error_msg').show();
                if (res.result === "0") {
                    $('#error_msg').hide();
                }
                $('#error_msg').html(res.result);
            }
        }
    });
};

$("#from_account").change(function() {
    getAvailableTransferAmount($("#coin").val(), $(this).val())
});

$("#coin").change(function() {
    getAvailableTransferAmount($(this).val(), $("#from_account").val())
});

@if(Session::has('authError'))
toastr.options = {
    "closeButton": true,
    "progressBar": true
}
toastr.error("{{ session('authError') }}");
@endif

@if(Session::has('authSuccess'))
toastr.options = {
    "closeButton": true,
    "progressBar": true
}
toastr.success("{{ session('authSuccess') }}");
@endif
</script>