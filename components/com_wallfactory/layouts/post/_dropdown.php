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

<div class="btn-group pull-right">
    <a class="btn dropdown-toggle btn-mini btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
        <span class="fa fa-fw fa-chevron-down"></span>
    </a>

    <ul class="dropdown-menu">
        <?php if (!$juser->guest && $juser->id == $post->user_id): ?>
            <li>
                <a href="<?php echo WallFactoryRoute::raw('post.delete&id=' . $post->id); ?>"
                   data-post="delete" class="dropdown-item"
                   data-confirm="<?php echo WallFactoryText::_('post_delete_confirm'); ?>">
                    <?php echo WallFactoryText::_('post_action_delete'); ?>
                </a>
            </li>
        <?php else: ?>
            <li>
                <?php echo JHtml::_('WallFactory.report', 'post', $post->id); ?>
            </li>
        <?php endif; ?>
    </ul>
</div>
