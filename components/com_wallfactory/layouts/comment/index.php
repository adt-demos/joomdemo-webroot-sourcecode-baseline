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

JHtml::script('media/com_wallfactory/assets/frontend/script.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/comments.js');

extract($displayData);

?>

<div class="comments" data-refresh="<?php echo WallFactoryRoute::raw('comment.load&format=raw&post_id=' . $postId); ?>">
    <?php foreach ($comments as $comment): ?>
        <?php echo JHtmlWallFactory::renderLayout('comment/_comment', array(
            'comment' => $comment,
        )); ?>
    <?php endforeach; ?>

    <?php if ($hasMore): ?>
        <div class="more-comments">
            <a href="<?php echo WallFactoryRoute::raw('comment.load&post_id=' . $postId); ?>"
               data-comments="more" class="btn btn-block btn-small btn-sm btn-secondary">
                <?php echo WallFactoryText::_('comments_load_more_comments'); ?>
            </a>
        </div>
    <?php endif; ?>
</div>

