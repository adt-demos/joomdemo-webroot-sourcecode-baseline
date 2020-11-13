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

<div class="submit-comment">
    <div class="user">
        <?php echo JHtmlWallFactory::profileAvatar($profile); ?>
    </div>

    <div class="contents">
        <form action="<?php echo WallFactoryRoute::raw('comment.submit'); ?>"
              data-captcha="<?php echo htmlentities($form->renderField('captcha')); ?>">
            <?php if ($form->getField('author_name')): ?>
                <?php echo $form->getField('author_name')->input; ?>
                <?php echo $form->getField('author_email')->input; ?>
            <?php endif; ?>
            <?php echo $form->getField('content')->input; ?>
            <?php echo $form->getField('post_id')->input; ?>

            <div class="comment-actions">
                <button type="submit" class="btn btn-small btn-sm btn-success">
                    <?php echo WallFactoryText::_('comment_button_submit_comment'); ?>
                </button>

                <a href="#" class="btn btn-small btn-link btn-sm" data-action="cancel">
                    <?php echo WallFactoryText::_('comment_button_cancel'); ?>
                </a>
            </div>
        </form>
    </div>
</div>
