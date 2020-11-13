jQuery(document).ready(function ($) {
    var $template = $('#media-video-template');
    var config = $('div.submit-post-buttons').data('config');

    $(document).on('media_button_video', 'div.submit-post-buttons', function () {
        var source = $template.html();
        var template = Handlebars.compile(source);

        $('div.submit-post-buttons').trigger('insert', [template, function () {
            this.find('input[type="text"]:first').focus();
        }]);
    });

    // Preview.
    $(document).on('change', 'div[data-media="video"] input[type="text"]', function () {
        var $element = $(this)
        var value = $.trim($element.val());
        var $preview = $element.parents('div.template-media').find('div.preview');
        var request;

        if ('' === value) {
            return false;
        }

        $element.addClass('loading');
        $preview.hide().removeClass('error');

        if ($element.data('request')) {
            $element.data('request').abort();
        }

        var url = config.upload.url_media_preview;
        var data = {
            type: 'video',
            video: value
        }

        request = $.get(url, data, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            $element.removeClass('loading');

            if (response.success) {
                $preview.html(response.output.render);
            } else {
                $preview.addClass('error').html(response.error);
            }

            $preview.show();
        }, 'json');

        $element.data('request', request);
    });
});
