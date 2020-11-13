<?php

/**
-------------------------------------------------------------------------
wallfactory - Wall Factory 4.1.8
-------------------------------------------------------------------------
 * @author thePHPfactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thePHPfactory.com
 * Technical Support: Forum - http://www.thePHPfactory.com/forum/
-------------------------------------------------------------------------
*/

defined('_JEXEC') or die;

extract($displayData);

JHtml::script('media/com_wallfactory/assets/frontend/js/post/video.js');

$adapters = array(
    'http://www.youtube.com'  => 'YouTube',
    'http://www.vimeo.com'    => 'Vimeo',
    'http://www.howcast.com'  => 'Howcast',
    'http://www.metacafe.com' => 'Metacafe',
    'http://www.myspace.com'  => 'MySpace',
);

array_walk($adapters, function (&$item, $key) {
    $item = '<a href="' . $key . '" target="_blank">' . $item . '</a>';
});

?>

<script id="media-video-template" type="text/x-handlebars-template" data-media="video"
        data-config="<?php echo htmlentities(json_encode($configuration)); ?>">
    <div class="template-media" data-media="video">
        {{> mediaRemoveButton }}
        <div class="media-title">
            <?php echo WallFactoryText::_('post_media_video_title'); ?>
        </div>

        <input name="post[media][{{id}}][video]" class="form-control"
               placeholder="<?php echo WallFactoryText::_('post_media_video_url_hint'); ?>" type="text">

        <div class="small muted text-muted" style="margin-top: 5px;">
            <?php echo WallFactoryText::sprintf('post_media_video_notification', implode(', ', $adapters)); ?>
        </div>

        <div class="preview" style="display: none;"></div>
    </div>
</script>
