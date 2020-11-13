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

<th width="1%" class="center">
    <?php echo JHtml::_('grid.checkall'); ?>
</th>

<th width="1%" class="nowrap hidden-phone center">
    Posts
</th>

<th width="1%" class="nowrap hidden-phone center">Avatar</th>

<th class="nowrap">
    User
</th>

<th class="nowrap hidden-phone" style="width: 120px;">
    Last posted at
</th>

<th class="nowrap hidden-phone" style="width: 120px;">
    <?php echo JHtml::_('searchtools.sort', 'Registered at', 'created_at', $this->listDirn, $this->listOrder); ?>
</th>

<th width="1%" class="nowrap hidden-phone">
    <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'p.user_id', $this->listDirn, $this->listOrder); ?>
</th>
