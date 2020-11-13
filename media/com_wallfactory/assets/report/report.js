jQuery(document).ready(function ($) {
    // Open report window.
    $(document).on('click', 'a[data-report]', function (event) {
        event.preventDefault();

        var $element = $(this),
            url = $element.attr('href');

        $.get(url, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            var $modal = $('<div>' + response + '</div>');

            // Modal construction.
            $modal.on('shown', function () {
                $modal.find('.hasPopover').popover({
                    'html': true,
                    'placement': 'right',
                    'trigger': 'hover focus',
                    'container': 'body'
                });

                autosize($modal.find('textarea'));
            });

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

    // Submit report form.
    $(document).on('submit', 'div.report-modal form', function (event) {
        event.preventDefault();

        var $form = $(this),
            $button = $form.find('button[type=submit]');

        if ($button.isLoading()) {
            return false;
        }

        $button.startLoading();
        $form.find('div.alert').remove();

        $.post($form.attr('action'), $form.serialize(), function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            $button.stopLoading();

            if (false === response.success) {
                $form.find('div.modal-body').prepend(
                    '<div class="alert alert-danger">' +
                    '<strong>' + response.message + '</strong><br />' +
                    response.error +
                    '</div>'
                );
            } else {
                $form.find('div.modal-body').html(response.message);
                $form.find('div.modal-footer .btn').toggle();
            }
        }, 'json');
    });
});
