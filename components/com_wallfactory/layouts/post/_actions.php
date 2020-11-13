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

extract($displayData); ?>

<div class="post-actions">
    <?php echo JHtmlWallFactory::likes($post->likes->total, 'post', $post->id); ?>
    <?php echo JHtmlWallFactory::like($post->likes->liked, 'post', $post->id); ?>
    <?php echo JHtmlWallFactory::bookmark($post->id); ?>

    <?php if ($juser->id != $post->user_id): ?>
        <?php echo JHtmlWallFactory::subscribe($post->subscribed, $post->user_id); ?>
    <?php endif; ?>

    <?php if ($comments): ?>
        <?php echo JHtmlWallFactory::comment($post->id); ?>
    <?php endif; ?>
</div>
