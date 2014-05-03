$(function() {
    $('.PhoneNo').click(function(event) {
        event.preventDefault();
        alert($('#MobileIP').val());
        $.ajax({
            type: 'POST',
            url: 'http://' + $('#MobileIP').val() + ':8080',
            dataType: 'jsonp',
            data: {
                'cellNo': $(this).text()
            }
        }).done(function(data) {
            try {
                console.log(data);
            }
            catch (e) {
            }
        }).fail(function(msg) {
            $('#Msg').html(msg);
        });
    });
});



