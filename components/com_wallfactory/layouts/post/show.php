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

JHtml::stylesheet('media/com_wallfactory/assets/font-awesome/css/font-awesome.css');
JHtml::stylesheet('media/com_wallfactory/assets/frontend/stylesheet.css');

JHtml::_('jQuery.framework');
JHtml::script('media/com_wallfactory/assets/frontend/script.js');
JHtml::script('media/com_wallfactory/assets/plugins/jquery.visible.min.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/posts.js');

extract($displayData);

?>

<div class="wallfactory-view">
    <?php if ($post): ?>
        <h1><?php echo WallFactoryText::sprintf('post_show_title', $post->id); ?></h1>

        <div class="posts">
            <?php echo JHtmlWallFactory::renderLayout('post._post', array(
                'post'     => $post,
                'comments' => $comments,
            )); ?>
        </div>
    <?php else: ?>
        <h1><?php echo WallFactoryText::_('post_show_not_found_error_title'); ?></h1>
        <p><?php echo WallFactoryText::_('post_show_not_found_error_text'); ?></p>
    <?php endif; ?>
</div>
