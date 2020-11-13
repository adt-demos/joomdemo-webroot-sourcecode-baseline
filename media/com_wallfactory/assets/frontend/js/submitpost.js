jQuery(document).ready(function ($) {
    var $textarea = $('textarea', 'div.submit-post');

    if ($.emojiarea) {
        var emojiarea = $textarea.emojiarea().data('emojiarea');

        emojiarea._blur = function () {
            if (!this._isEmpty()) {
                return;
            }

            this.$editor.html(this._placeholder());
        };

        emojiarea._focus = function () {
            if (this._placeholder() !== this.$editor.html()) {
                return;
            }

            this.$editor.html('');
        };

        emojiarea._placeholder = function () {
            return '<div class="muted text-muted">' + this.$textarea.attr('placeholder') + '</div>';
        };

        emojiarea._reset = function () {
            this.$editor.html('');
            this._blur();
        };

        emojiarea._isEmpty = function () {
            if ('' === this.$editor.html()) {
                return true;
            }

            if ('<br>' === this.$editor.html()) {
                return true;
            }

            if (this._placeholder() === this.$editor.html()) {
                return true;
            }

            return false;
        };

        emojiarea._isBlank = function () {
            if (this._isEmpty()) {
                return true;
            }

            if ('' === $.trim(this.$editor.html())) {
                return true;
            }

            return false;
        };

        emojiarea._blur();

        emojiarea.$editor.focus(function () {
            emojiarea._focus();

            showFormActions();
        });

        emojiarea.$editor.blur(function () {
            emojiarea._blur();
        });
    }
    else {
        autosize($textarea);

        $textarea.focus(function () {
            showFormActions();
        });
    }

    function showFormActions() {
        var $submitPost = $('div.submit-post');

        $submitPost.find('div.submit-post-actions').show();

        if ($submitPost.find('div.submit-post-buttons button').length) {
            $submitPost.find('div.submit-post-buttons').show();
        }

        var $form = $textarea.parents('form:first');
        var captcha = $form.data('captcha');

        if ('' !== captcha && 0 === $submitPost.find('div#post_captcha').length) {
            $(captcha).insertBefore($form.find('div.submit-post-actions a[data-action="submit"]'));

            var items = $form.find('.g-recaptcha'), item, options;

            for (var i = 0, l = items.length; i < l; i++) {
                item = items[i];
                options = item.dataset ? item.dataset : {
                    sitekey: item.getAttribute('data-sitekey'),
                    theme: item.getAttribute('data-theme'),
                    size: item.getAttribute('data-size')
                };
                grecaptcha.render(item, options);
            }
        }
    }

    // Form cancel button.
    $('a[data-action="cancel"]', 'div.submit-post-actions').click(function (event) {
        event.preventDefault();

        var $submitPost = $(this).parents('div.submit-post');

        $submitPost.trigger('reset');
    });

    // Form reset.
    $(document).on('reset', 'div.submit-post', function () {
        var $element = $(this);

        $element.find('div.submit-post-actions').hide();

        if ($element.find('div.submit-post-buttons button').length) {
            $element.find('div.submit-post-buttons').hide();
        }

        $element.find('div.submit-post-media').html('');
        $element.find('div#post_captcha').parents('div.control-group:first').remove();

        if (emojiarea) {
            emojiarea._reset();
        }
        else {
            $textarea.val('');
            var evt = document.createEvent('Event');
            evt.initEvent('autosize:update', true, false);
            $textarea[0].dispatchEvent(evt);
        }
    });

    // Form submit button.
    $('[data-action="submit"]', 'div.submit-post-actions').click(function (event) {
        event.preventDefault();

        var $button = $(this);

        if ($button.isLoading()) {
            return false;
        }

        var $form = $button.parents('form:first');
        var data = $form.serialize();

        if (emojiarea) {
            if (emojiarea._isBlank()) {
                emojiarea.$editor.focus();
                return false;
            }
        } else {
            if ('' === $.trim($textarea.val())) {
                $textarea.focus();
                return false;
            }
        }


        $button.startLoading();

        $.post($form.attr('action'), data, function (response) {
            if (true === $.checkAjaxRedirect(response)) {
                return false;
            }

            $button.stopLoading();

            if (response.success) {
                $('div.posts').trigger('refresh');
                $button.parents('div.submit-post:first').trigger('reset');
            }
            else {
                $button.showTooltip(response);
            }
        }, 'json');
    });

    // Form remove media button.
    $(document).on('click', 'a[data-post-media="remove"]', function (event) {
        event.preventDefault();

        $(this).parents('div.template-media:first').remove();
    });


    Handlebars.registerPartial('mediaRemoveButton',
        '<a href="#" class="pull-right muted remove-media" data-post-media="remove">' +
        '<span class="fa fa-fw fa-times"></span>remove' +
        '</a>'
    );

    var $buttons = $('div.submit-post-buttons');
    var config = $buttons.data('config');
    var source = $('#media-button-template').html();
    var template = Handlebars.compile(source);

    $('script[data-media]').each(function (index, element) {
        var $element = $(element);
        var config = $element.data('config');

        if (parseInt(config.enabled) === 0) {
            return;
        }

        if (parseInt(config.limit) === 0) {
            return;
        }

        var button = config.button;
        var html = template({
            type: $element.data('media'),
            tooltip: button.tooltip,
            icon: button.icon
        });

        $buttons.append(html);
    });

    $(document).on('click', 'div.submit-post-buttons button[data-media-button]', function (event) {
        event.preventDefault();

        var type = $(this).data('media-button');

        if (!limitCheck(type)) {
            return false;
        }

        $buttons.trigger('media_button_' + type);
    });

    var counter = 0;

    $buttons.bind('insert', function (event, template, callback, limitCheckType) {
        if (limitCheckType && !limitCheck(limitCheckType)) {
            return false;
        }

        var $html = $(template({id: counter++}));

        $('div.submit-post-media').prepend($html);

        if (callback) {
            callback.call($html);
        }
    });

    function limitCheck(type) {
        var config = $('script[data-media="' + type + '"]').data('config');
        var limit = config.limit;

        if (limit <= $('div[data-media="' + type + '"]').length) {
            return false;
        }

        return true;
    }
});
