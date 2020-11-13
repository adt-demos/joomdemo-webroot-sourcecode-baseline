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

<td>
    <a class="hasTooltip" href="<?php echo WallFactoryRoute::task('notification.edit&id=' . $this->item->id); ?>">
        <?php echo $this->escape($this->item->subject); ?>
    </a>

    <div class="muted text-muted small" style="line-height: normal;">
        <?php echo JHtml::_('string.truncate', $this->item->body, 100, true, false); ?>
    </div>
</td>

<td class="nowrap">
    <?php if (isset($this->types[$this->item->type])): ?>
        <?php echo $this->types[$this->item->type]; ?>
    <?php else: ?>
        <?php echo JText::_('JUNDEFINED'); ?>
    <?php endif; ?>

    <?php echo JHtml::_('WallFactoryList.filter',
        $this->getName() . '&filter[type]=' . $this->item->type,
        $this->getName() . '_filter_type'
    ); ?>

    <?php if (!$this->configuration->get('notifications.' . $this->item->type . '.enabled', 1)): ?>
        <div>
            <span class="label badge badge-pill badge-danger label-important"><?php echo WallFactoryText::_('notifications_notification_disabled'); ?></span>
        </div>
    <?php elseif (in_array($this->item->type, $this->groupNotifications)): ?>
        <div>
            <?php if ($groups = $this->configuration->get('notifications.' . $this->item->type . '.groups', array())): ?>
                <?php foreach ($groups as $group): ?>
                    <span class="label badge badge-pill badge-info label-info"><?php echo JAccess::getGroupTitle($group); ?></span>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="label badge badge-pill badge-danger label-important"><?php echo WallFactoryText::_('notification_group_not_set'); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</td>

<td class="hidden-phone nowrap">
    <?php if ($this->item->language == '*'): ?>
        <?php echo JText::alt('JALL', 'language'); ?>
    <?php else: ?>
        <?php echo $this->item->language_title ? JHtml::_('image', 'mod_languages/' . $this->item->language_image . '.gif', $this->item->language_title, array('title' => $this->item->language_title), true) . '&nbsp;' . $this->escape($this->item->language_title) : JText::_('JUNDEFINED'); ?>
    <?php endif; ?>

    <?php echo JHtml::_('WallFactoryList.filter',
        $this->getName() . '&filter[language]=' . $this->item->language,
        $this->getName() . '_filter_language'
    ); ?>
</td>

<td class="hidden-phone">
    <?php echo (int)$this->item->id; ?>
</td>
