jQuery.fn.extend({
    loadingClass: 'btn-loading',

    startLoading: function () {
        var $element = jQuery(this);

        $element
            .css('min-width', $element.outerWidth())
            .css('min-height', $element.outerHeight())
            .addClass(this.loadingClass)
            .blur();
    },

    stopLoading: function () {
        var $element = jQuery(this);

        $element
            .removeClass(this.loadingClass);
    },

    isLoading: function () {
        return jQuery(this).hasClass(this.loadingClass);
    },

    showTooltip: function (response) {
        var $element = jQuery(this);

        var bsVersion = undefined === jQuery.fn.tooltip.Constructor.VERSION ? 3 : 4;
        var destroy = 3 === bsVersion ? 'destroy' : 'dispose';

        $element.tooltip(destroy);

        $element.tooltip({
            title: '<b>' + response.message + '</b><div>' + response.error + '</div>',
            container: 'body',
            html: true,
            trigger: 'manual'
        });

        $element.tooltip('show');
    },
});

jQuery.extend({
    checkAjaxRedirect: function (response) {
        try {
            if (typeof response !== 'object') {
                response = JSON.parse(response);
            }

            if (response._redirect) {
                window.location.href = response._redirect
                return true;
            }
        } catch (e) {
        }

        return false;
    }
})

jQuery(document).ready(function ($) {
    $('img[data-src]').on('lazyload', function (event, target) {
        $(target).removeAttr('style');
    });

    $(document).on('click', 'html', function () {
        $('div.tooltip').remove();
    });
});

