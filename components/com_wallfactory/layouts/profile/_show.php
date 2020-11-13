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

JHtml::script('media/com_wallfactory/assets/frontend/js/profile.js');

extract($displayData);

?>

<div class="row-fluid row">
    <div class="span3 col-3" style="text-align: center;">
        <div class="avatar-wrapper">
            <?php echo JHtmlWallFactory::profileAvatar($profile); ?>

            <?php if ($isMyProfile && $canUploadAvatar): ?>
                <a href="<?php echo WallFactoryRoute::raw('avatar.upload'); ?>" class="upload-link" id="upload-link">
                    <span class="fa fa-fw fa-camera"></span>
                </a>

                <div class="progress-bar-wrapper">
                    <div class="progress progress-striped">
                        <div class="bar" style="width: 0;"></div>
                    </div>
                </div>

                <input type="file" style="display: none;" id="upload-avatar-file" accept=".gif,.jpg,.jpeg,.png"/>
            <?php endif; ?>
        </div>

        <?php if ($isMyProfile && $canUploadAvatar): ?>
            <div class="small muted text-muted update-avatar-notice">
                <?php echo WallFactoryText::_('profile_update_avatar_notice'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="span9 col-9">
        <div class="control-group">
            <label class="control-label"><?php echo WallFactoryText::_('profile_label_name'); ?></label>
            <div class="controls"><?php echo $profile->name; ?></div>
        </div>

        <div class="control-group">
            <label class="control-label"><?php echo WallFactoryText::_('profile_label_description'); ?></label>
            <div class="controls">
                <?php if ($profile->description): ?>
                    <?php echo JHtmlWallFactory::nl2p($profile->description); ?>
                <?php else: ?>
                    <span class="muted text-muted"><?php echo WallFactoryText::_('profile_no_description'); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($isMyProfile): ?>
            <div class="profile-actions">
                <?php if ($allowSelfProfileRemoval): ?>
                    <a href="<?php echo WallFactoryRoute::task('profile.delete'); ?>"
                       class="btn btn-danger btn-small pull-right">
                        <?php echo WallFactoryText::_('profile_button_delete'); ?>
                    </a>
                <?php endif; ?>

                <a href="<?php echo WallFactoryRoute::task('profile.update'); ?>" class="btn btn-primary btn-small">
                    <?php echo WallFactoryText::_('profile_button_update'); ?>
                </a>

                <?php if ($hasNotifications): ?>
                    <a href="<?php echo WallFactoryRoute::task('notification.index'); ?>"
                       class="btn btn-link btn-small">
                        <span class="fa fa-fw fa-bell"></span><?php echo WallFactoryText::_('profile_button_notifications'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
