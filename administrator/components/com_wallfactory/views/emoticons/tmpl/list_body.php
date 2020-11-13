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

<td class="order nowrap center hidden-phone">
    <?php echo JHtml::_('WallFactoryList.ordering', $this->saveOrder, $this->item->ordering); ?>
</td>

<td class="center">
    <?php echo JHtml::_('grid.id', $this->i, $this->item->id); ?>
</td>

<td class="center">
    <?php echo JHtml::_('jgrid.published', $this->item->published, $this->i, $this->getName() . '.', true, 'cb'); ?>
</td>

<td class="center">
    <img src="<?php echo JUri::root(); ?>media/com_wallfactory/storage/emoticons/<?php echo $this->item->filename; ?>">
</td>

<td>
    <a class="hasTooltip" href="<?php echo WallFactoryRoute::task('emoticon.edit&id=' . $this->item->id); ?>">
        <?php echo $this->escape($this->item->title); ?>
    </a>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->id; ?>
</td>
