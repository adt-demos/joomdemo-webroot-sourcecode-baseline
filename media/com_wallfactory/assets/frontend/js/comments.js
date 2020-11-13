jQuery(document).ready(function ($) {
    $(document).on('click', 'a[data-comments="more"]', function (event) {
        event.preventDefault();

        var $button = $(this),
            $comments = $button.parents('div.comments');

        if ($button.isLoading()) {
            return false;
        }

        $button.startLoading();

        $comments.loadComments({
            direction: 'older',
            callback: function () {
                $button.stopLoading();
                $button.parent('div.more-comments').remove();
            }
        });
    });

    $(document).on('click', 'a[data-delete="comment"]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href');

        $.get(url, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            if (!response.success) {
                alert(response.error);
            } else {
                $element.parents('div.comment:first').html(response.message);
            }
        }, 'json');
    });
});

(function ($) {
    $.fn.loadComments = function (options) {

        var settings = $.extend({
            direction: 'newer',
            callback: function () {
            }
        }, options);

        var $element = $(this),
            url = $element.data('refresh');
        var timestamp;

        var location = 'newer' === settings.direction ? 'first' : 'last';
        timestamp = $element.find('div.comment:' + location).data('timestamp');

        var data = {
            timestamp: timestamp,
            direction: settings.direction
        };

        $.get(url, data, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            var $list = $(response);

            if ('newer' === settings.direction) {
                var $firstComment = $element.find('div.comment:first');

                if ($firstComment.length) {
                    $list.find('div.comment').insertBefore($firstComment);
                } else {
                    $element.append($list.html());
                }
            } else {
                $element.append($list.html());
            }

            settings.callback.apply();
        });
    };
}(jQuery));
