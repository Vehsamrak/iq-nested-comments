$(function () {
    $('.comment .button.open').click(function (event) {
        event.stopPropagation();

        var requestData = {
            'parentCommentId': $(this).parent().data('id')
        };

        $.post('/comment/list', requestData, function (response) {
            console.log(response);
        });
    });
});
