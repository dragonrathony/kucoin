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
                if (res.data) {
                    let result = res.data.result;
                    if (result.code === "200000") {
                        toastr.success('Authenticated successfully');
                        showData2Blocks(result.data);
                    } else {
                        toastr.error(result.msg);
                    }
                } else {
                    toastr.error('Server error');
                }
            }
        });
    }


    // display data to two blocks
    function showData2Blocks(data) {
        console.log('show block data...', data);
        let main = {},
            trade = {},
            margin = {}
        theta_usdt = 0;

        data.map(function(item) {
            if (item.type === "main") {
                if (item.currency === "THETA") {
                    main.theta = parseFloat(item.balance);
                    theta_usdt += parseFloat(item.balance);
                }
                if (item.currency === "USDT") {
                    main.usdt = parseFloat(item.balance);
                    theta_usdt += parseFloat(item.balance);
                }
            }

            if (item.type === "trade") {
                if (item.currency === "THETA") {
                    trade.theta = parseFloat(item.balance);
                    theta_usdt += parseFloat(item.balance);
                }
                if (item.currency === "USDT") {
                    trade.usdt = parseFloat(item.balance);
                    theta_usdt += parseFloat(item.balance);
                }
            }

            if (item.type === "margin") {
                if (item.currency === "THETA") {
                    margin.theta = parseFloat(item.balance);
                    theta_usdt += parseFloat(item.balance);
                }
                if (item.currency === "USDT") {
                    margin.theta = parseFloat(item.balance);
                    // margin.theta = parseFloat(item.balance).toFixed(2);
                    theta_usdt += parseFloat(item.balance);
                }
            }
        });

        theta_usdt = theta_usdt.toFixed(2);
        console.log('data...', main, trade, margin, theta_usdt);

        $('#current_price').text(theta_usdt);
        $('#main_theta').text(main.theta);
        $('#main_usdt').text(main.usdt);
        $('#trade_theta').text(trade.theta);
        $('#trade_usdt').text(trade.usdt);
        $('#margin_theta').text(margin.theta);
        $('#margin_usdt').text(margin.usdt);
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