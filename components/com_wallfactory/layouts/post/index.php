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

JHtml::script('media/com_wallfactory/assets/plugins/jquery.visible.min.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/posts.js');

extract($displayData);

?>

<div class="posts" data-url="<?php echo $dataUrl; ?>">
    <?php if (!$posts): ?>
        <p>
            <?php echo WallFactoryText::_('posts_no_posts_to_display'); ?>
        </p>
    <?php else: ?>
        <p style="margin: 0 0 12px;">
            <?php echo WallFactoryText::plural('posts_total_number', $pagination->total); ?>
        </p>

        <?php echo JHtmlWallFactory::renderLayout('post._list', array(
            'posts'    => $posts,
            'comments' => $comments,
        )); ?>

        <?php echo JHtmlWallFactory::pagination($pagination); ?>
    <?php endif; ?>
</div>
