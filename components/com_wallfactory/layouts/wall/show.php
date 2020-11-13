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

extract($displayData);

?>

<div class="wallfactory-view">
    <?php if ($toProfile): ?>
        <div>
            <div class="pull-right">
                <a href="<?php echo WallFactoryRoute::task('profile.show&id=' . $toProfile->user_id); ?>" class="btn btn-secondary">
                    <?php echo WallFactoryText::sprintf('wall_link_profile', $toProfile->name); ?>
                </a>
            </div>
            <h1><?php echo $toProfile->name; ?></h1>
        </div>

        <?php echo JHtmlWallFactory::renderTask('post.form', array(
            'userId' => $toProfile->user_id,
        )); ?>

        <?php echo JHtmlWallFactory::renderTask('wall.posts', array(
            'userId'     => $toProfile->user_id,
            'comments'   => $comments,
            'limitstart' => $limitstart,
        )); ?>
    <?php else: ?>
        <h1><?php echo WallFactoryText::_('wall_error_user_not_found_title'); ?></h1>
        <p><?php echo WallFactoryText::_('wall_error_user_not_found_text'); ?></p>
    <?php endif; ?>
</div>
