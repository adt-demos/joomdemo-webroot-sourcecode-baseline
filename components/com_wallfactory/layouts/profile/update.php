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

if (3 === (int)\Joomla\CMS\Version::MAJOR_VERSION) {
    JHtml::_('formbehavior.chosen', 'select');
}

JHtml::stylesheet('media/com_wallfactory/assets/frontend/stylesheet.css');

JHtml::_('jQuery.framework');
JHtml::script('media/com_wallfactory/assets/autosize/autosize.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/profileupdate.js');

extract($displayData);

?>

<div class="wallfactory-view view-profileupdate">
    <h1><?php echo WallFactoryText::_('profileupdate_page_title'); ?></h1>

    <form action="<?php echo WallFactoryRoute::task('profile.update'); ?>" method="post">
        <?php echo $form->renderFieldset('details'); ?>

        <div class="profileupdate-actions">
            <button type="submit" class="btn btn-small btn-primary">
                <?php echo WallFactoryText::_('profileupdate_button_update'); ?>
            </button>

            <a href="<?php echo WallFactoryRoute::task('profile.show'); ?>" class="btn btn-small btn-link">
                <?php echo WallFactoryText::_('profileupdate_button_cancel'); ?>
            </a>
        </div>
    </form>
</div>

