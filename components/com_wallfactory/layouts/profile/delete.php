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

?>

<div class="wallfactory-view view-profiledelete">
    <h1><?php echo WallFactoryText::_('profiledelete_page_title'); ?></h1>
    <p><?php echo WallFactoryText::_('profiledelete_page_info'); ?></p>

    <form action="<?php echo WallFactoryRoute::task('profile.delete'); ?>" method="post">
        <div class="profiledelete-actions">
            <button type="submit" class="btn btn-small btn-danger pull-right">
                <?php echo WallFactoryText::_('profiledelete_button_submit'); ?>
            </button>

            <a href="<?php echo WallFactoryRoute::task('profile.show'); ?>" class="btn btn-small btn-primary">
                <?php echo WallFactoryText::_('profiledelete_button_cancel'); ?>
            </a>
        </div>

        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>

