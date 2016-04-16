var notificationList = (function(){
    console.log('notification list js was initilized');

    var readNotification = function(div){
        var notification_id = div.attr('id');
        console.log('reading notification ' + notification_id);

        $.ajax({
                url: to_read_notice,
                type: 'GET',
                dataType: 'json',
                data: {id: notification_id},
            })
            .done(function() {
                console.log("notification read");
            })
            .fail(function() {
                console.log("notification not read");
            })
            .always(function() {
                div.removeClass("alert-success").addClass("alert-warning").find(".not_read").hide();
            });

    };
    $(document).on('click','.not_read',{},function(){
         readNotification($(this).closest("div.not_list_item"));
    });
    return {
       
    };
})();