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

extract($displayData);

?>

<div class="wallfactory-view view-notification-index">
    <h1><?php echo WallFactoryText::_('notifications_page_title'); ?></h1>

    <form action="<?php echo WallFactoryRoute::task('notification.update'); ?>" method="post">
        <?php echo $form->renderFieldset('details'); ?>

        <div class="actions">
            <button type="submit" class="btn btn-small btn-primary">
                <?php echo WallFactoryText::_('notifications_button_submit'); ?>
            </button>

            <a href="<?php echo WallFactoryRoute::task('profile.show'); ?>" class="btn btn-small btn-link">
                <?php echo WallFactoryText::_('notifications_button_cancel'); ?>
            </a>
        </div>
    </form>
</div>
