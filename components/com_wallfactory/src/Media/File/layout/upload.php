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

JHtml::script('media/com_wallfactory/assets/frontend/js/post/file.js');

?>

<input type="file" style="display: none;" id="media-file-template-file"
       accept="<?php echo implode(',', $configuration->get('valid_extensions')); ?>" multiple="multiple"/>

<script id="media-file-template" type="text/x-handlebars-template" data-media="file"
        data-config="<?php echo htmlentities(json_encode($configuration)); ?>">
    <div class="template-media" data-media="file">
        {{> mediaRemoveButton }}

        <div class="media-title">
            <?php echo WallFactoryText::_('post_media_file_title'); ?>
        </div>

        <input name="post[media][{{id}}][file][title]" id="post_media_{{id}}_file_title" class="form-control"
               placeholder="<?php echo WallFactoryText::_('post_media_file_title_hint'); ?>" type="text">
        <div style="margin-top: 10px;">
            <textarea name="post[media][{{id}}][file][description]" id="post_media_{{id}}_file_description"
                      placeholder="<?php echo WallFactoryText::_('post_media_file_description_hint'); ?>"
                      rows="2" class="form-control"></textarea>
        </div>

        <div class="progress progress-striped active">
            <div class="bar"></div>
        </div>

        <input type="hidden" name="post[media][{{id}}][file][upload][filename]">
        <input type="hidden" name="post[media][{{id}}][file][upload][extension]">
        <input type="hidden" name="post[media][{{id}}][file][upload][name]">

        <div class="preview" style="display: none;"></div>
    </div>
</script>
