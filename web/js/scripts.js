$(function () {
    $('.comment .button.open').click(function (event) {
        event.stopPropagation();

        var $this = $(this);
        var $comment = $this.parent().parent();
        var requestData = {
            'parentCommentId': $comment.data('id')
        };

        $this.hide();

        $.post('/comment/list', requestData, function (comments) {
            JSON.parse(comments).reverse().forEach(function (comment) {
                renderComment(comment.id, comment.text, comment.level).insertAfter($comment);
            });
        });

        function renderComment(commentId, commentText, commentLevel) {
            var $html = $('<div class="comment" data-id="' + commentId + '">' +
                '<div class="text">' + commentText + '</div>' +
                '<div class="buttons">' +
                '<span class="button edit" title="Edit this comment"></span>' +
                '<span class="button delete" title="Delete this comment and all his children"></span>' +
                '</div></div>');

            for (var i = 1; i < commentLevel; i++) {
                $('<div class="level-block"></div>').insertBefore($html.find('.text'));
            }

            return $html;
        }
    });
});
