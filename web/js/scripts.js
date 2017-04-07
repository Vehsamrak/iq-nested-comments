$(function () {
    var $body = $('body');

    $('.comment .button.open').click(function (event) {
        event.stopPropagation();

        var $this = $(this);
        var $comment = $this.closest('.comment');
        var requestData = {'parentCommentId': $comment.data('id')};

        $comment.siblings().remove();

        $this.hide();
        $('<div class="level-block"></div>').insertAfter($this);

        $.post('/comment/list', requestData, function (comments) {
            JSON.parse(comments).reverse().forEach(function (comment) {
                renderComment(comment.id, comment.text, comment.level).insertAfter($comment);
            });
        });
    });

    $('#add-comment').click(function () {
        var $postNewComment = $('#post-new-comment');

        $(this).hide();
        $postNewComment.find('textarea').val('');
        $postNewComment.show();
    });

    $('#post-new-comment .button.post').click(function () {
        var $this = $(this);
        var text = $this.siblings('textarea').val();

        $this.parent().hide();

        $.post('/comment/add', {'text': text}, function (responseData) {
            var commentId = JSON.parse(responseData);
            var level = 1;

            var $comment = renderComment(commentId, text, level);

            $comment.insertAfter($('.comment').last());

            $('#add-comment').show();
        });
    });

    $body.on('click', '.button.edit', function () {
        var $this = $(this);
        var $buttons = $this.closest('.buttons');
        var $textContainer = $this.closest('.comment').find('.text');
        var text = $textContainer.html();

        $buttons.hide();

        $textContainer.html('<textarea cols="50" rows="3">' + text + '</textarea>' +
            '<span class="button save">Save</span>');
    });

    $body.on('click', '.button.save', function () {
        var $this = $(this);
        var $comment = $this.closest('.comment');
        var $buttons = $comment.find('.buttons');
        var $textContainer = $comment.find('.text');
        var text = $comment.find('textarea').val();

        $.post('/comment/edit', {
            'id': $comment.data('id'),
            'text': text
        }, function () {
            $textContainer.html(text);
            $buttons.show();
        });
    });

    $body.on('click', '.button.reply', function () {
        var $this = $(this);
        var $buttons = $this.closest('.buttons');
        var $textContainer = $this.closest('.comment').find('.text');

        $buttons.hide();

        $textContainer.append('<p class="reply-block"><textarea cols="50" rows="3"></textarea>' +
            '<span class="button post-reply">Reply</span></p>');
    });

    $body.on('click', '.button.post-reply', function () {
        var $this = $(this);
        var $comment = $this.closest('.comment');
        var $buttons = $comment.find('.buttons');
        var text = $comment.find('textarea').val();
        var parentCommentId = $comment.data('id');

        $.post('/comment/add', {'text': text, 'parentCommentId': parentCommentId}, function (responseData) {
            var commentId = JSON.parse(responseData);
            var level = $comment.data('level') + 1;

            var $newComment = renderComment(commentId, text, level);

            $newComment.insertAfter($comment);
        });

        $buttons.show();
        $('p.reply-block').remove();
    });

    function renderComment(commentId, commentText, commentLevel) {
        var $html = $('<div class="comment" data-id="' + commentId + '" data-level="' + commentLevel + '">' +
            '<div class="level-block"></div>' +
            '<div class="text">' + commentText + '</div>' +
            '<div class="buttons">' +
            '<span class="button reply" title="Reply to this comment"></span>' +
            '<span class="button edit" title="Edit this comment"></span>' +
            '<span class="button delete" title="Delete this comment and all his children"></span>' +
            '</div></div>');

        for (var i = 1; i < commentLevel; i++) {
            $('<div class="level-block"></div>').insertBefore($html.find('.text'));
        }

        return $html;
    }
});
