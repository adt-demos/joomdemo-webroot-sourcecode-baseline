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

JHtml::script('media/com_wallfactory/assets/frontend/js/post/link.js');

?>

<script id="media-link-template" type="text/x-handlebars-template" data-media="link"
        data-config="<?php echo htmlentities(json_encode($configuration)); ?>">
    <div class="template-media" data-media="link">
        {{> mediaRemoveButton }}

        <div class="media-title">
            <?php echo WallFactoryText::_('post_media_link_title'); ?>
        </div>

        <input name="post[media][{{id}}][link]" placeholder="<?php echo WallFactoryText::_('post_media_link_hint'); ?>"
               class="form-control" type="text">

        <div class="preview" style="display: none;"></div>
    </div>
</script>
