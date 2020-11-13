jQuery(document).ready(function ($) {
    $(document).on('click', 'a[data-subscribe]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href');

        $element.blur();

        if ($element.isLoading()) {
            return false;
        }

        $element.startLoading();

        $.post(url, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            $element.stopLoading();

            if (true === response.success) {
                $('a[data-subscribe="' + response.user_id + '"]').replaceWith(response.html);
            } else {
                $element.showTooltip(response);
            }
        }, 'json');
    });
});
