<script>
    var _token = $("input[name=_token]").val();
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }


    function ajaxCall(url, data, type = 'POST') {
        console.log('ajax call...', url, data, type);
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
                if (res.data) {
                    let result = res.data.result;
                    if (result.code === "200000") {
                        console.log('auth success result...', result.data);
                        toastr.success('Authenticated successfully');
                    } else {
                        toastr.error(result.msg);
                    }
                } else {
                    toastr.error('Server error');
                }

                $.LoadingOverlay("hide");
            }
        });
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