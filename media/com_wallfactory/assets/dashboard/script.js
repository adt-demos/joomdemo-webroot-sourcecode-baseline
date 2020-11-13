jQuery(document).ready(function ($) {
    var $columns = $('div.columns');

    $('div.sortable').sortable({
        items: 'div.panel',
        handle: 'span.handle',
        placeholder: 'sortable-placeholder',
        connectWith: 'div.sortable',
        tolerance: 'pointer',
        forcePlaceholderSize: true,

        start: function (event, ui) {
            ui.item.css('opacity', .5);
        },

        stop: function (event, ui) {
            ui.item.css('opacity', 1);

            $columns.trigger('save');
        }
    });

    $columns.on('click', 'div.panel-heading span.toggle', function () {
        var $element = $(this);

        $element
            .parents('div.panel:first')
            .toggleClass('open')
            .toggleClass('closed');

        $columns.trigger('save');
    });

    $columns.on('save', function () {
        var data = [];

        $('div.panel', 'div.sortable').each(function (index, element) {
            var $element = $(element),
                $sortable = $element.parents('div.sortable:first'),
                column = $sortable.index(),
                panel = $element.data('panel'),
                status = $element.find('div.panel-body').is(':visible') ? 'open' : 'closed';

            data.push({column: column, panel: panel, status: status});
        });

        Cookies.set($columns.data('option') + '_dashboard', data);
    });
});
