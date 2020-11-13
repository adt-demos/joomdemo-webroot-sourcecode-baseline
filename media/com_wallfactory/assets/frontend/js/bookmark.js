jQuery(document).ready(function ($) {
    $(document).on('click', 'a[data-action="bookmark"]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href'),
            $contents = $element.parents('div.post-contents');

        if ($element.isLoading()) {
            return false;
        }

        $element.startLoading();

        if ($element.data('loaded')) {
            $element.stopLoading();

            $contents.find('div.bookmarks').slideToggle('fast');
        } else {
            $.get(url, function (response) {
                if (true === $.checkAjaxRedirect(response)) {
                    return false;
                }

                var $response = $(response);

                $element.stopLoading();
                $response.hide();
                $element.data('loaded', true);

                $response.insertAfter($contents.find('div.post-actions')).slideToggle('fast');
            });
        }
    });
});
