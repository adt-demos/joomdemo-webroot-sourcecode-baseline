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
    <?php echo JHtml::_('grid.id', $this->i, $this->item->user_id); ?>
</td>

<td class="hidden-phone nowrap center">
    <?php echo JHtml::_('WallFactory.badgeNumberSuccess',
        $this->item->posts,
        WallFactoryRoute::view('posts&reset=1&filter[user_id]=' . $this->item->user_id)
    ); ?>
</td>

<td>
    <?php echo JHtmlWallFactory::profileAvatar($this->item); ?>
</td>

<td class="nowrap">
    <a href="<?php echo WallFactoryRoute::task('user.edit&id=' . $this->item->user_id); ?>">
        <?php echo $this->item->name; ?>
    </a>

    <div class="small muted text-muted">
        <a href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . $this->item->user_id); ?>"
           class="muted text-muted">
            <?php echo $this->item->username; ?>
        </a>
    </div>
</td>

<td class="muted text-muted hidden-phone nowrap">
    <?php echo JHtml::_('date', $this->item->last_post_at, 'COM_WALLFACTORY_FORMAT_DATE'); ?>
</td>

<td class="muted text-muted hidden-phone nowrap">
    <?php echo JHtml::_('date', $this->item->created_at, 'COM_WALLFACTORY_FORMAT_DATE'); ?>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->user_id; ?>
</td>
