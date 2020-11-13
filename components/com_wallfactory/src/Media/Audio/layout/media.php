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

extract($displayData['media']);

JHtml::script('media/com_wallfactory/assets/jplayer/jquery.jplayer.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/post/audio.js');

$file = JUri::root() . 'media/com_wallfactory/storage/media/audio/' . $path . '/' . $filename;

?>

<div class="post-media-audio">
    <div class="audio-player">
        <div
                id="audio-player-<?php echo $id; ?>"
                class="jp-jplayer"
                data-audio-player="<?php echo $id; ?>"
                data-audio-file="<?php echo htmlentities($file); ?>">
        </div>
        <div id="audio-container-<?php echo $id; ?>" class="jp-audio" role="application" aria-label="media player">
            <div class="audio-wrapper">
                <a href="#" class="jp-play">
                    <span class="fa fa-fw fa-play"></span>
                </a>

                <div class="jp-volume-controls">
                    <button class="jp-mute" role="button" tabindex="0">
                        <span class="fa fa-fw fa-volume-up"></span>
                    </button>
                </div>

                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar" style="width: 0;"></div>
                        <div class="jp-duration" role="timer" aria-label="time">&nbsp;</div>
                        <div class="jp-title"><?php echo $title; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($description): ?>
        <div class="audio-details">
            <?php echo nl2br($description); ?>
        </div>
    <?php endif; ?>
</div>
