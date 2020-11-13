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

?>

<div class="comment" data-id="<?php echo $comment->id; ?>" data-timestamp="<?php echo $comment->created_at; ?>">
    <div class="comment-user">
        <?php if ($comment->user_id): ?>
            <?php echo JHtmlWallFactory::profileAvatar($comment); ?>
        <?php else: ?>
            <?php echo JHtmlWallFactory::guestAvatar($comment); ?>
        <?php endif; ?>
    </div>

    <div class="comment-contents">
        <?php echo JHtmlWallFactory::renderLayout('comment._actions', array(
            'comment' => $comment,
        )); ?>

        <?php if ($comment->user_id): ?>
            <a href="<?php echo WallFactoryRoute::task('profile.show&id=' . $comment->user_id); ?>">
                <b class="username"><?php echo $comment->profile_name; ?></b>
            </a>
        <?php else: ?>
            <b class="username"><?php echo $comment->author_name; ?></b>
        <?php endif; ?>

        <div class="small muted text-muted">
            <?php echo JHtml::_('date', $comment->created_at, 'd F Y, H:i'); ?>
        </div>

        <div class="comment-text">
            <?php echo JHtml::_('WallFactory.nl2p', $comment->content); ?>
        </div>
    </div>
</div>
