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

extract($displayData);

?>
<?php if ($field->value): ?>
    <img src="<?php echo JUri::root(); ?>media/com_wallfactory/bookmarks/<?php echo $field->value; ?>"/>
<?php else: ?>
    <span class="muted text-muted">
    <?php echo WallFactoryText::_('field_bookmark_thumbnail_no_thumbnail'); ?>
  </span>
<?php endif; ?>

