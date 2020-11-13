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
$lazyLoad = $displayData['configuration']->get('lazy_load', 'view');

?>

<div class="post-media-video">
    <?php if ($lazyLoad): ?>
        <?php echo JHtml::_('WallFactory.mediaVideoThumbnail', $thumbnail, $player, $lazyLoad); ?>
    <?php else: ?>
        <?php echo $player; ?>
    <?php endif; ?>

    <?php if ($title || $description): ?>
        <div class="video-details">
            <a href="<?php echo $url; ?>" target="_blank">
                <?php echo $title; ?>
            </a>

            <div>
                <?php echo nl2br($description); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
