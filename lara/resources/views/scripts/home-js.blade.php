<script>
    var _token = $("input[name=_token]").val();
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }


    function ajaxCall(url, data, type = 'POST') {
        $.LoadingOverlay("show");
        $.ajax({
            url: url,
            method: type,
            data: {
                _token: _token,
                data: data
            },
            success: function(res) {
                console.log('ajax result...', res);
                $.LoadingOverlay("hide");
                if (res.status === "success") {
                    toastr.success('Authenticated successfully');
                    showData2Blocks(res.data);
                } else {
                    toastr.error(res.data);
                }
            }
        });
    }


    // display data to two blocks
    function showData2Blocks(data) {
        console.log('show block data...', data);

        $('#current_price').text(data.current_price);
        $('#main_theta').text(data.main_theta);
        $('#main_usdt').text(data.main_usdt);
        // $('#trade_theta').text(data.current_price);
        // $('#trade_usdt').text(data.current_price);
        $('#margin_theta_total').text(data.theta_total);
        $('#margin_debt_ratio').text((parseFloat(data.debtRatio) * 100).toFixed(2));
        $('#margin_usdt_total').text(data.usdt_total);
        $('#margin_usdt_liability').text(data.usdt_liability);
    }


    $('#auth_submit').click(function() {
        var accId = $('#accId').val();
        var apiKey = $('#apiKey').val();
        var pw = $('#pw').val();
        var secret = $('#secret').val();

        if (accId && apiKey && pw && secret) {
            var url = "{{url('home/auth')}}";
            var type = 'POST';
            var data = {
                accId: accId,
                apiKey: apiKey,
                pw: pw,
                secret: secret
            };
            ajaxCall(url, data, type);
        } else {
            toastr.error('Please type all information');
        }

    });
</script>