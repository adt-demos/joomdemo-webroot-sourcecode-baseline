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

<div class="wallfactory-view view-profile">
    <div>
        <div class="pull-right">
            <a href="<?php echo WallFactoryRoute::task('wall.show&user_id=' . $profile->user_id); ?>" class="btn btn-secondary">
                <?php echo WallFactoryText::sprintf('profile_link_go_to_wall', $profile->name); ?>
            </a>
        </div>
        <h1><?php echo $profile->name; ?></h1>
    </div>

    <?php echo JHtml::_('bootstrap.startTabSet', 'profile', array('active' => 'user')); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'profile', 'user', WallFactoryText::_('profile_tab_profile')); ?>
    <?php echo JHtmlWallFactory::renderLayout('profile._show', array(
        'profile'                 => $profile,
        'isMyProfile'             => $isMyProfile,
        'allowSelfProfileRemoval' => $allowSelfProfileRemoval,
        'hasNotifications'        => $hasNotifications,
        'canUploadAvatar'         => $canUploadAvatar,
    )); ?>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'profile', 'posts', WallFactoryText::_('profile_tab_posts')); ?>
    <div class="posts">
        <?php echo JHtmlWallFactory::renderTask('post.latest', array(
            'user_id' => $profile->user_id,
        )); ?>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php if ($config->get('like.enabled', 1)): ?>
        <?php echo JHtml::_('bootstrap.addTab', 'profile', 'likes', WallFactoryText::_('profile_tab_likes')); ?>
        <div class="posts">
            <?php echo JHtmlWallFactory::renderTask('like.latest', array(
                'user_id' => $profile->user_id,
            )); ?>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
    <?php endif; ?>

    <?php echo JHtml::_('bootstrap.addTab', 'profile', 'subscriptions', WallFactoryText::_('profile_tab_subscriptions')); ?>
    <?php echo JHtmlWallFactory::renderTask('subscription.latest', array(
        'user_id' => $profile->user_id,
    )); ?>
    <?php echo JHtml::_('bootstrap.endTab'); ?>
    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
</div>
