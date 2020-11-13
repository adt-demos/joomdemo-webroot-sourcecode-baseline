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

<td>
    <img src="<?php echo JHtml::_('WallFactoryBookmark.src', $this->item->thumbnail); ?>"/>
</td>

<td>
    <a class="hasTooltip" href="<?php echo WallFactoryRoute::task('bookmark.edit&id=' . $this->item->id); ?>">
        <?php echo $this->escape($this->item->title); ?>
    </a>

    <div class="muted text-muted" style="line-height: normal;">
        <?php echo JHtml::_('string.truncate', $this->item->link, 150); ?>
    </div>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->id; ?>
</td>
