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

JHtml::script('media/com_wallfactory/assets/jplayer/jquery.jplayer.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/post/audio.js');

?>

<input type="file" style="display: none;" id="media-audio-template-file"
       accept="<?php echo implode(',', $configuration->get('valid_extensions')); ?>" multiple="multiple"/>

<script id="media-audio-template" type="text/x-handlebars-template" data-media="audio"
        data-config="<?php echo htmlentities(json_encode($configuration)); ?>">
    <div class="template-media template-media-audio" data-media="audio">
        {{> mediaRemoveButton }}

        <div class="media-title">
            <?php echo WallFactoryText::_('post_media_audio_title'); ?>
        </div>

        <input name="post[media][{{id}}][audio][title]" id="post_media_{{id}}_audio_title" class="form-control"
               placeholder="<?php echo WallFactoryText::_('post_media_audio_title_hint'); ?>" type="text">
        <div style="margin-top: 10px;">
            <textarea name="post[media][{{id}}][audio][description]" id="post_media_{{id}}_audio_description"
                      placeholder="<?php echo WallFactoryText::_('post_media_audio_description_hint'); ?>"
                      rows="2" class="form-control"></textarea>
        </div>

        <div class="progress progress-striped active">
            <div class="bar"></div>
        </div>

        <input type="hidden" name="post[media][{{id}}][audio][upload][filename]">
        <input type="hidden" name="post[media][{{id}}][audio][upload][extension]">
        <input type="hidden" name="post[media][{{id}}][audio][upload][name]">

        <div class="preview" style="display: none;">
            <div class="audio-player">
                <div id="audio-player-{{id}}" class="jp-jplayer" data-audio-player="{{id}}" data-audio-file=""></div>
                <div id="audio-container-{{id}}" class="jp-audio" role="application" aria-label="media player">
                    <div class="audio-wrapper">
                        <a href="#" class="jp-play"><span class="fa fa-fw fa-play"></span></a>
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar" style="width: 0;"></div>
                                <div class="jp-duration" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-title">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
