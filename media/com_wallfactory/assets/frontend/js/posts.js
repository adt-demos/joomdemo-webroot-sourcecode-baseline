jQuery(document).ready(function ($) {
    $(document).on('click', 'a[data-post="delete"]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href');

        if (!confirm($element.data('confirm'))) {
            return false;
        }

        $.post(url, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            if (response.success) {
                $element.parents('div.post:first').html('<div class="muted">' + response.message + '</div>');
            } else {
                alert($element.error);
            }
        }, 'json');
    });

    $('div.posts').bind('refresh', function () {
        var $posts = $(this),
            url = $posts.data('url'),
            timestamp = $posts.find('div.post:first').data('timestamp');

        $.get(url, {timestamp: timestamp}, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            var $html = $('<div>' + response + '</div>').find('div.post');

            $posts.prepend($html);

            setTimeout(function () {
                if ('function' === typeof $(window).lazyLoadXT) {
                    $(window).lazyLoadXT();
                }
            }, 10);
        });
    });

    $(document).on('click', 'div.thumbnail-wrapper[data-lazy-load="click"]', function (event) {
        event.preventDefault();

        $(this).replaceWith($(this).data('lazy-video'));
    });

    $(window).scroll(function () {
        $('div.thumbnail-wrapper[data-lazy-load="view"]').each(function (index, element) {
            var $element = $(element);

            if ($element.visible()) {
                $element.replaceWith($element.data('lazy-video'));
            }
        });
    });

    setTimeout(function () {
        $(window).scroll();
    }, 1000);
});
