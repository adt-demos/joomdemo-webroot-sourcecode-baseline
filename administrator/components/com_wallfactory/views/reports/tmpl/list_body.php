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
    <?php echo JHtml::_('WallFactoryList.actionResolveReport',
        $this->item->resolved,
        $this->i,
        $this->getName()
    ); ?>
</td>

<td class="center">
    <?php echo JHtml::_('WallFactoryList.actionEdit', $this->i, $this->getName()); ?>
</td>

<td>
    <?php echo JHtml::_('string.truncate', $this->item->comment, 200, true, false); ?>
</td>

<td class="nowrap">
    <a href="<?php echo WallFactoryRoute::task($this->item->resource_type . '.edit&id=' . $this->item->id); ?>"><?php echo $this->item->resource_title; ?></a>

    <?php echo JHtml::_('WallFactoryList.filter',
        $this->getName() . '&filter[resource_id]=' . $this->item->resource_id . '&filter[resource_type]=' . $this->item->resource_type,
        $this->getName() . '_filter_resource'
    ); ?>

    <div class="muted text-muted">
        <?php echo WallFactoryText::_('report_type_' . $this->item->resource_type); ?>

        <?php echo JHtml::_('WallFactoryList.filter',
            $this->getName() . '&filter[resource_type]=' . $this->item->resource_type,
            $this->getName() . '_filter_type'
        ); ?>
    </div>
</td>

<td class="nowrap">
    <?php if ($this->item->resource_user_id): ?>
        <a href="<?php echo WallFactoryRoute::task('task=user.edit&id=' . $this->item->resource_user_id); ?>"><?php echo $this->item->reported_name; ?></a>

        <?php echo JHtml::_('WallFactoryList.filter',
            $this->getName() . '&filter[resource_user_id]=' . $this->item->resource_user_id,
            $this->getName() . '_filter_resource_user_id'
        ); ?>

        <div>
            <a class="small muted text-muted"
               href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . $this->item->resource_user_id); ?>">
                <?php echo $this->item->resource_username; ?></a>
        </div>
    <?php else: ?>
        <span class="muted">Guest</span>
    <?php endif; ?>
</td>

<td class="nowrap">
    <a href="<?php echo WallFactoryRoute::task('task=user.edit&id=' . $this->item->user_id); ?>"><?php echo $this->item->reporting_name; ?></a>

    <?php echo JHtml::_('WallFactoryList.filter',
        $this->getName() . '&filter[user_id]=' . $this->item->user_id,
        $this->getName() . '_filter_user_id'
    ); ?>

    <div>
        <a class="small muted text-muted"
           href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . $this->item->user_id); ?>"><?php echo $this->item->reporting_username; ?></a>
    </div>
</td>

<td class="muted text-muted hidden-phone nowrap">
    <?php echo JHtml::_('date', $this->item->created_at, 'COM_WALLFACTORY_FORMAT_DATE'); ?>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->id; ?>
</td>
