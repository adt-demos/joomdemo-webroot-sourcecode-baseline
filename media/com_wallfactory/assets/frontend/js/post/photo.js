jQuery(document).ready(function ($) {
    var $template = $('#media-photo-template');
    var config = $('div.submit-post-buttons').data('config');
    var $file = $('input#media-photo-template-file');
    var photoConfig = $('script[data-media="photo"]').data('config');

    $(document).on('media_button_photo', 'div.submit-post-buttons', function () {
        $file.click();
    });

    $file.change(function () {
        var source = $template.html();
        var template = Handlebars.compile(source);

        for (var i = 0, count = this.files.length; i < count; i++) {
            var file = this.files[i];

            // Check for valid file extensions.
            var extension = '.' + file.name.split('.').pop().toLowerCase();
            if (-1 === $.inArray(extension, photoConfig.valid_extensions)) {
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

                this.addClass('photo-pending-upload').data('photo', file);

            }, 'photo']);
        }

        startUpload();
    });

    function startUpload() {
        var $pending = $('div.photo-pending-upload:first', 'div.submit-post-media');
        var url = config.upload.url_media_preview;

        if (!$pending.length) {
            return true;
        }

        $pending.removeClass('pending');

        var fd = new FormData();
        fd.append('photo', $pending.data('photo'));
        fd.append('type', 'photo');

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
                    var $progress = $pending.find('div.progress');

                    if (undefined !== response.output.path) {
                        $preview.find('img').attr('src', response.output.path);

                        $progress.fadeOut();
                        $preview.fadeIn();
                    }
                    else {
                        reader.onload = function (event) {
                            $preview.find('img').attr('src', event.target.result);

                            $progress.fadeOut();
                            $preview.fadeIn();
                        };

                        reader.readAsDataURL($pending.data('photo'));
                    }
                } else {
                    $pending.find('div.progress')
                        .replaceWith('<div class="alert alert-danger">' + response.error + '</div>');
                }
            },
            complete: function () {
                $pending.removeClass('photo-pending-upload').data('photo', undefined);
                startUpload();
            }
        });
    }
});
