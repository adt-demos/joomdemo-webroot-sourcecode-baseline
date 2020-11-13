jQuery(document).ready(function ($) {
    $(document).on('click', 'a[data-comment]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href'),
            $comments = $element.parents('div.post-contents').find('div.comments');

        if ($element.isLoading()) {
            return false;
        }

        $element.startLoading();

        if ($element.data('loaded')) {
            $element.stopLoading();

            $comments.find('div.submit-comment').slideToggle('fast').find('textarea').focus();

            var $form = $comments.find('form:first');
            initReCaptcha($form);
        } else {
            $.get(url, function (response) {
                if (true === $.checkAjaxRedirect(response)) {
                    return false;
                }

                var $response = $(response);

                $element.stopLoading();
                $response.hide();
                $element.data('loaded', true);

                $comments.prepend($response);
                $response.slideToggle('fast');

                var $form = $comments.find('form:first');
                initReCaptcha($form);

                autosize($response.find('textarea'));

                $response.find('textarea').focus();
            });
        }
    });

    function initReCaptcha($form) {
        if ('' === $form.data('captcha')) {
            return false;
        }

        var $control = $($form.data('captcha'));
        var $captcha = $control.find('div.g-recaptcha');
        var options = {
            sitekey: $captcha.data('sitekey'),
            theme: $captcha.data('theme'),
            size: $captcha.data('size')
        };

        $control.insertBefore($form.find('div.comment-actions'));

        grecaptcha.render($captcha[0], options);

        return true;
    }

    $(document).on('click', 'div.submit-comment a[data-action="cancel"]', function (event) {
        event.preventDefault();

        var $comment = $(this).parents('div.submit-comment'),
            $textarea = $comment.find('textarea');

        $textarea.val('').blur();

        var evt = document.createEvent('Event');
        evt.initEvent('autosize:update', true, false);
        $textarea[0].dispatchEvent(evt);

        $comment.slideUp();
        $comment.find('div.g-recaptcha').parents('div.control-group').remove();
    });

    $(document).on('submit', 'div.submit-comment form', function (event) {
        event.preventDefault();

        var $form = $(this),
            url = $form.attr('action'),
            $button = $form.find('button');

        if ($button.isLoading()) {
            return false;
        }

        $button.startLoading();

        $.post(url, $form.serialize(), function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            $button.stopLoading();

            if (response.success) {
                $form.find('a[data-action="cancel"]').click();

                $form.parents('div.comments').loadComments({
                    direction: 'newer'
                });
            }
            else {
                $button.showTooltip(response);
            }
        }, 'json');
    });
});
