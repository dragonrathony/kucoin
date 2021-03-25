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
                $.LoadingOverlay("hide");
                toastr.success(res.msg);
            }
        });
    }


    $('#auth_submit').click(function() {
        var accId = $('#accId').val();
        var apiKey = $('#apiKey').val();
        var pw = $('#pw').val();
        var secret = $('#secret').val();

        var url = "{{url('home/auth')}}";
        var type = 'POST';
        var data = {
            accId: accId,
            apiKey: apiKey,
            pw: pw,
            secret: secret
        };
        ajaxCall(url, data, type);
    });
</script>