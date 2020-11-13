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
    <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
        <span class="fa fa-fw fa-chevron-down"></span>
    </a>

    <ul class="dropdown-menu pull-right">
        <?php if ($juser->guest || $juser->id != $comment->user_id): ?>
            <li>
                <?php echo JHtml::_('WallFactory.report', 'comment', $comment->id); ?>
            </li>
        <?php else: ?>
            <li>
                <a href="<?php echo WallFactoryRoute::raw('comment.delete&id=' . $comment->id); ?>"
                   data-delete="comment">
                    <?php echo WallFactoryText::_('comment_action_delete'); ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
