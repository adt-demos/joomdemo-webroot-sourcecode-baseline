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

<div class="post" data-timestamp="<?php echo $post->created_at; ?>">
    <div class="post-user">
        <?php if ($post->user_id): ?>
            <?php echo JHtmlWallFactory::profileAvatar($post); ?>
        <?php else: ?>
            <?php echo JHtmlWallFactory::guestAvatar($post); ?>
        <?php endif; ?>
    </div>

    <div class="post-contents">
        <?php echo JHtmlWallFactory::renderLayout('post._dropdown', array(
            'post' => $post,
        )); ?>

        <div class="post-owner">
            <?php if ($post->user_id): ?>
                <a href="<?php echo WallFactoryRoute::wall($juser, $post->user_id); ?>"><b
                            class="username"><?php echo $post->name; ?></b></a>
            <?php else: ?>
                <span class="username muted text-muted"><b><?php echo $post->name; ?></b></span>
            <?php endif; ?>

            <?php if ($post->user_id !== $post->to_user_id && $post->to_user_id): ?>
                <span class="fa fa-fw fa-caret-right muted text-muted"></span>
                <a href="<?php echo WallFactoryRoute::wall($juser, $post->to_user_id); ?>">
                    <b class="username"><?php echo $post->to_name; ?></b></a>
            <?php endif; ?>

            <div class="small muted text-muted">
                <?php echo JHtml::_('date', $post->created_at, 'd F Y, H:i'); ?>
            </div>
        </div>

        <div class="post-text">
            <?php echo JHtmlWallFactory::content($post->content); ?>
        </div>

        <?php if ($post->media): ?>
            <div class="post-media">
                <?php foreach ($post->media as $media): ?>
                    <div class="post-media-item">
                        <?php echo \ThePhpFactory\Wall\Media\MediaFactory::build($media->type)->renderMedia($media); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php echo JHtmlWallFactory::renderLayout('post._actions', array(
            'post'     => $post,
            'comments' => $comments,
        )); ?>

        <?php if ($comments): ?>
            <?php echo JHtmlWallFactory::renderTask('comment.index', array(
                'post_id' => $post->id,
            )); ?>
        <?php endif; ?>
    </div>
</div>
