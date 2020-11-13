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

<div class="wallfactory-view">
    <div class="modal likes-modal" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <?php echo WallFactoryText::_('likes_modal_title'); ?>
                    </h3>
                </div>

                <div class="modal-body">
                    <?php if (!$likes): ?>
                        <p>
                            <?php echo WallFactoryText::_('likes_no_likes_found'); ?>
                        </p>
                    <?php else: ?>
                        <div class="list">
                            <?php foreach ($likes as $like): ?>
                                <div class="item">
                                    <div class="user">
                                        <?php echo JHtmlWallFactory::profileAvatar($like); ?>
                                    </div>
                                    <div>
                                        <?php if ($like->name): ?>
                                            <a href="<?php echo WallFactoryRoute::task('profile.show&id=' . $like->user_id); ?>"
                                               class="username">
                                                <b><?php echo $like->name; ?></b>
                                            </a>
                                        <?php else: ?>
                                            <span class="muted text-muted"><?php echo WallFactoryText::_('likes_user_not_found'); ?></span>
                                        <?php endif; ?>

                                        <div class="muted text-muted small">
                                            <?php echo JHtml::_('date', $like->created_at, 'd F Y, H:i'); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" data-dismiss="modal">
                        <?php echo WallFactoryText::_('likes_modal_button_close'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
