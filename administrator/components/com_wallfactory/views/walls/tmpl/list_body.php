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

<td class="center">
    <?php echo JHtml::_('grid.id', $this->i, $this->item->id); ?>
</td>

<td class="center">
    <?php echo JHtml::_('jgrid.published', $this->item->published, $this->i, $this->getName() . '.', true, 'cb'); ?>
</td>

<td class="hidden-phone nowrap center">
    <?php echo JHtml::_('WallFactory.badgeNumberSuccess',
        $this->item->posts,
        WallFactoryRoute::view('posts&reset=1&filter[wall_id]=' . $this->item->id)
    ); ?>
</td>

<td>
    <a class="hasTooltip"
       href="<?php echo WallFactoryRoute::task($this->getNameSingular() . '.edit&id=' . $this->item->id); ?>">
        <?php echo $this->escape($this->item->title); ?>
    </a>

    <div class="muted text-muted" style="line-height: normal;">
        <?php echo JHtml::_('WallFactory.description', $this->item->description); ?>
    </div>
</td>

<td class="hidden-phone nowrap">
    <a href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . $this->item->user_id); ?>">
        <?php echo $this->item->name; ?>
    </a>

    <div class="muted text-muted">
        <?php echo $this->item->username; ?>
    </div>
</td>

<td class="muted text-muted hidden-phone nowrap">
    <?php echo JHtml::_('date', $this->item->created_at, 'COM_WALLFACTORY_FORMAT_DATE'); ?>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->id; ?>
</td>
