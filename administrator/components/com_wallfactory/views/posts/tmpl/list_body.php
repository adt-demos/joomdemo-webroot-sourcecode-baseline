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
        $this->item->comments,
        WallFactoryRoute::view('comments&reset=1&filter[post_id]=' . $this->item->id)
    ); ?>
</td>

<td class="center">
    <?php echo JHtml::_('jgrid.action', $this->i, 'post.edit', '', '', WallFactoryText::_('posts_edit_post'), '', true, 'pencil-2'); ?>
</td>

<td>
    <?php echo JHtml::_('WallFactory.content', $this->item->content); ?>
</td>

<td class="nowrap" style="line-height: normal;">
    <?php if ($this->item->user_id): ?>
        <a href="<?php echo WallFactoryRoute::task('user.edit&id=' . $this->item->user_id); ?>"><?php echo $this->item->name; ?></a>

        <?php echo JHtml::_('WallFactoryList.filter',
            $this->getName() . '&filter[user_id]=' . $this->item->user_id,
            'posts_filter_user'
        ); ?>

        <div>
            <a href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . $this->item->user_id); ?>"
               class="muted text-muted small">
                <?php echo JHtml::_('WallFactory.username', $this->item->username); ?>
            </a>
        </div>
    <?php else: ?>
        <?php echo $this->item->name; ?>

        <div class="small muted text-muted">
            <?php echo $this->item->author_email; ?>
        </div>
    <?php endif; ?>
</td>

<td class="nowrap" style="line-height: normal;">
    <?php if ($this->item->to_user_id && $this->item->user_id != $this->item->to_user_id): ?>
        <a href="<?php echo WallFactoryRoute::task('user.edit&id=' . $this->item->to_user_id); ?>"><?php echo $this->item->to_name; ?></a>

        <?php echo JHtml::_('WallFactoryList.filter',
            $this->getName() . '&filter[to_user_id]=' . $this->item->to_user_id,
            'posts_filter_user'
        ); ?>
    <?php endif; ?>
</td>

<td class="muted text-muted hidden-phone nowrap">
    <?php echo JHtml::_('date', $this->item->created_at, 'COM_WALLFACTORY_FORMAT_DATE'); ?>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->id; ?>
</td>
