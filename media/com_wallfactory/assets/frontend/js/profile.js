jQuery(document).ready(function ($) {
    $('a.upload-link', 'div.avatar-wrapper').click(function (event) {
        event.preventDefault();
        $('input#upload-avatar-file', 'div.avatar-wrapper').click();
    });

    $('input#upload-avatar-file', 'div.avatar-wrapper').change(function () {
        $('div.avatar-wrapper').addClass('loading');
        $('div.progress-bar-wrapper', 'div.avatar-wrapper').show();

        var formData = new FormData,
            file = this.files[0],
            url = $('a.upload-link', 'div.avatar-wrapper').attr('href'),
            $progressBar = $('div.bar', 'div.progress-bar-wrapper');

        $progressBar.width(0);

        formData.append('file', file);

        $.ajax({
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            type: 'POST',

            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener('progress', function (event) {
                    if (event.lengthComputable) {
                        $progressBar.width(Math.round(event.loaded / event.total * 100) + '%');
                    }
                }, false);

                return xhr;
            },

            complete: function () {
                $('div.avatar-wrapper').removeClass('loading');
                $('div.progress-bar-wrapper', 'div.avatar-wrapper').hide();
            },

            success: function (response, textStatus, jqXHR) {
                if (true === $.checkAjaxRedirect(response)) {
                    return false;
                }

                if (!response.success) {
                    alert(response.message + "\n\n" + response.error);
                } else {
                    var time = new Date().getTime()
                    $('img', 'div.avatar-wrapper').attr('src', response.path + '?' + time);
                }
            }
        });
    });
});
