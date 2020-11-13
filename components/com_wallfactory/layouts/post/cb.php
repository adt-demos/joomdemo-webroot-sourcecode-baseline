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
    <?php echo JHtmlWallFactory::renderTask('post.form', array(
        'userId' => $toProfile ? $toProfile->user_id : 0,
    )); ?>

    <?php if (!$posts): ?>
        <p>
            <?php echo WallFactoryText::_('posts_no_posts_to_display'); ?>
        </p>
    <?php else: ?>
        <div class="posts" data-url="<?php echo $dataUrl; ?>">
            <?php echo JHtmlWallFactory::renderLayout('post._list', array(
                'posts'    => $posts,
                'comments' => true,
            )); ?>
        </div>
    <?php endif; ?>
</div>
