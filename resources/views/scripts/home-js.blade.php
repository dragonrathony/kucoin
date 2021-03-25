<script>
    var _token = $("input[name=_token]").val();
    console.log('home js...', _token);


    function ajaxCall(url, data, type = 'POST') {
        console.log('ajax call...', url, data, type);
        $.ajax({
            url: url,
            method: type,
            data: {
                _token: _token,
                data: data
            },
            success: function(res) {
                console.log('ajax result...', res);
            }
        });
    }


    $('#auth_submit').click(function() {
        var accId = $('#accId').val();
        var apiKey = $('#apiKey').val();

        var url = "{{url('home/auth')}}";
        var type = 'POST';
        var data = {
            accId: accId,
            apiKey: apiKey
        };
        ajaxCall(url, data, type);
    });
</script>