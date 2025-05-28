jQuery(document).ready(function($) {
    function mediaUploader(targetInput) {
        const media = wp.media({
            title: 'Select Image',
            multiple: false,
            library: { type: 'image' },
            button: { text: 'Use this image' }
        });

        media.on('select', function () {
            const attachment = media.state().get('selection').first().toJSON();
            $(targetInput).val(attachment.url);
        });

        media.open();
    }

    $('#upload_logo_button').on('click', function(e) {
        e.preventDefault();
        mediaUploader('#calb_login_logo');
    });

    $('#upload_bg_button').on('click', function(e) {
        e.preventDefault();
        mediaUploader('#calb_login_bg');
    });
});
