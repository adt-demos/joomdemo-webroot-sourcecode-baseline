jQuery(document).ready(function ($) {
    var $template = $('#media-audio-template');
    var config = $('div.submit-post-buttons').data('config');
    var $file = $('input#media-audio-template-file');
    var audioConfig = $('script[data-media="audio"]').data('config');

    $(document).on('media_button_audio', 'div.submit-post-buttons', function () {
        $file.click();
    });

    $file.change(function () {
        var source = $template.html();
        var template = Handlebars.compile(source);

        for (var i = 0, count = this.files.length; i < count; i++) {
            var file = this.files[i];

            // Check for valid file extensions.
            var extension = '.' + file.name.split('.').pop();
            if (-1 === $.inArray(extension, audioConfig.valid_extensions)) {
                continue;
            }

            // Check for file size.
            if (config.upload.max_file_size.value < file.size) {
                alert(config.upload.max_file_size.error.replace('{{ file }}', file.name));
                continue;
            }

            $('div.submit-post-buttons').trigger('insert', [template, function () {

                this.find('input[type="text"]:first').focus();
                autosize(this.find('textarea'));

                this.addClass('audio-pending-upload').data('audio', file);

            }, 'audio']);
        }

        startUpload();
    });

    function startUpload() {
        var $pending = $('div.audio-pending-upload:first', 'div.submit-post-media');
        var url = config.upload.url_media_preview;

        if (!$pending.length) {
            return true;
        }

        $pending.removeClass('pending');

        var fd = new FormData();
        fd.append('audio', $pending.data('audio'));
        fd.append('type', 'audio');

        $.ajax({
            url: url,
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            type: 'POST',
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                xhr.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        $('.progress .bar', $pending).css('width', '' + (100 * e.loaded / e.total) + '%');
                    }
                });
                return xhr;
            },
            success: function (response) {
                if (true === $.checkAjaxRedirect(response)) {
                    return false;
                }

                if (response.success) {
                    $pending.find('input[type="hidden"][name*="[filename]"]').val(response.output.filename);
                    $pending.find('input[type="hidden"][name*="[extension]"]').val(response.output.extension);
                    $pending.find('input[type="hidden"][name*="[name]"]').val(response.output.name);

                    var reader = new FileReader();
                    var $preview = $pending.find('div.preview');
                    var $player = $preview.find('div[data-audio-file]');
                    var $title = $preview.find('div.jp-title');

                    reader.onload = function (event) {
                        $player.data('audio-file', event.target.result);
                        $title.text(response.output.name);

                        $preview.fadeIn();
                        $pending.find('div.progress').fadeOut();
                    }
                    reader.readAsDataURL($pending.data('audio'));
                } else {
                    $pending.find('div.progress')
                        .replaceWith('<div class="alert alert-danger">' + response.error + '</div>');
                }
            },
            complete: function () {
                $pending.removeClass('audio-pending-upload').data('audio', undefined);
                startUpload();
            }
        });
    }

    $(document).on('click', 'div.audio-player a.jp-play', function (event) {
        event.preventDefault();

        var $player = $(this).parents('div.audio-player').find('div[data-audio-player]');

        if (!$player.data('init')) {
            $player.WallFactoryAudioPlayer();
            $player.data('init', true);
        }
    });

    jQuery.fn.extend({
        WallFactoryAudioPlayer: function () {
            return this.each(function () {
                var $element = $(this);
                var id = $element.data('audio-player');
                var file = $element.data('audio-file');

                $element.jPlayer({
                    ready: function () {
                        $(this).jPlayer('setMedia', {
                            mp3: file
                        });

                        $(this).jPlayer('play');
                    },
                    play: function (event) {
                        $(this).jPlayer('pauseOthers');

                        $(event.jPlayer.options.cssSelectorAncestor)
                            .find('a.jp-play span').toggleClass('fa-play fa-pause');
                    },
                    pause: function (event) {
                        $(event.jPlayer.options.cssSelectorAncestor)
                            .find('a.jp-play span').toggleClass('fa-play fa-pause');
                    },
                    volumechange: function (event) {
                        $('button.jp-mute span').toggleClass('fa-volume-up fa-volume-off');
                    },
                    cssSelectorAncestor: "#audio-container-" + id,
                    swfPath: "/js",
                    supplied: "mp3",
                    useStateClassSkin: true,
                    autoBlur: true,
                    smoothPlayBar: true,
                    remainingDuration: true
                });
            });
        }
    });
});
