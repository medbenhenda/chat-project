/**
 * Created by viasyst on 16/02/2018.
 */
$(function() {

    function LoadMessages()
    {
        $.get( "/unread-messages", function( data ) {
            $( ".unread-messages" ).html( data );
        });
    }
    setInterval( LoadMessages, 10000 );

    $('[id^=itemuser-]').click(function(e) {
        $('.message_notif').html(' ');
        var id_selector = this.id;
        var arr = id_selector.split('-');
        var id_user = arr[1];
        console.log(id_user);
        $('input[name="destination"]').val(id_user);
        $.ajax({
            url: '/received-messages/' + id_user,
            type: "GET",
            data: { id: id_user },
            dataType: 'html',
            success: function (responseHTMLData) {
                $( ".recieved-messages" ).html( responseHTMLData );
            }
        });
        e.preventDefault();
    });

    $('form').submit(function(event) {
        if ( $('input[name=destination]').val()) {
            $('.message_notif').html('');
            var formData = {
                'destination': $('input[name=destination]').val(),
                'message': $('textarea[name=message]').val()
            };

            $.ajax({
                type: 'POST',
                url: '/send-message',
                data: formData,
                encode: true
            })
                .done(function (data) {
                    $(".recieved-messages").html(data);
                });

            event.preventDefault();
        } else {
            $('.message_notif').html('You must select an user');
            event.preventDefault();
        }
    });
});


