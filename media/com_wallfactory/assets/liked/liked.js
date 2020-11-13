jQuery(document).ready(function ($) {
    var bsVersion = undefined === $.fn.tooltip.Constructor.VERSION ? 3 : 4;
    var destroy = 3 === bsVersion ? 'destroy' : 'dispose';

    $(document).on('click', 'a[data-like]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href');

        if ($element.hasClass('btn-loading')) {
            return false;
        }

        $element.css('min-width', $element.outerWidth());
        $element.css('min-height', $element.outerHeight());
        $element.addClass('btn-loading');

        $.post(url, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            $element.removeClass('btn-loading');

            if (true === response.success) {
                $('[data-likes="' + response.resource.type + '"][data-id="' + response.resource.id + '"]')
                    .fadeOut('fast', function () {
                        $(this).replaceWith(response.likes);
                    });

                $element.replaceWith(response.html);
            }
            else {
                $element.tooltip(destroy);

                $element.tooltip({
                    title: '<b>' + response.message + '</b><div>' + response.error + '</div>',
                    html: true,
                    container: 'body',
                    trigger: 'manual'
                });

                $element.tooltip('show');
            }
        }, 'json');
    });

    $(document).on('click', 'html', function () {
        $('div.tooltip').remove();
    });

    $(document).on('click', 'a[data-likes]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href');

        if ($element.hasClass('btn-loading')) {
            return false;
        }

        $element.css('min-width', $element.outerWidth());
        $element.css('min-height', $element.outerHeight());
        $element.addClass('btn-loading');

        $.get(url, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            $element.removeClass('btn-loading');

            var $modal = $('<div>' + response + '</div>');

            // Modal destruction.
            $modal.on('hidden', function () {
                $modal.remove();
            });

            // Modal initialization.
            $modal.modal({
                show: true,
                backdrop: 'static'
            });
        });
    });
});
