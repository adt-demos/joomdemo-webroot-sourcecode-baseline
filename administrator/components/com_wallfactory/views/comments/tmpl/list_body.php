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

<td class="center">
    <?php echo JHtml::_('WallFactoryList.actionEdit', $this->i, $this->getName()); ?>
</td>

<td>
    <?php echo JHtml::_('string.truncate', $this->item->content, 180, true, false); ?>
</td>

<td class="nowrap">
    <?php if ($this->item->user_id): ?>
        <a href="<?php echo WallFactoryRoute::task('user.edit&id=' . $this->item->user_id); ?>"><?php echo $this->item->name; ?></a>

        <?php echo JHtml::_('WallFactoryList.filter',
            $this->getName() . '&filter[user_id]=' . $this->item->user_id,
            $this->getName() . '_filter_user'
        ); ?>

        <div>
            <a class="small muted text-muted"
               href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . $this->item->user_id); ?>"><?php echo $this->item->username; ?></a>
        </div>
    <?php else: ?>
        <?php echo $this->item->author_name; ?>

        <div class="small muted text-muted">
            <?php echo $this->item->author_email; ?>
        </div>
    <?php endif; ?>

<td class="nowrap">
    <a href="<?php echo WallFactoryRoute::task('post.edit&id=' . $this->item->post_id); ?>"><?php echo WallFactoryText::sprintf('post_title', $this->item->post_id); ?></a>

    <?php echo JHtml::_('WallFactoryList.filter',
        $this->getName() . '&filter[post_id]=' . $this->item->post_id,
        $this->getName() . '_filter_post'
    ); ?>
</td>

<td class="muted text-muted hidden-phone nowrap">
    <?php echo JHtml::_('date', $this->item->created_at, 'COM_WALLFACTORY_FORMAT_DATE'); ?>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->id; ?>
</td>
