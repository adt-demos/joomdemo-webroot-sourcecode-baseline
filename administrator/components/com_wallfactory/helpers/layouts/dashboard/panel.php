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

extract($displayData); ?>

<div
        class="panel panel-default <?php echo $state; ?> panel-<?php echo $id; ?>"
        data-panel="<?php echo $id; ?>">
    <div class="panel-heading">
        <span class="fa fa-fw fa-ellipsis-v handle"></span>
        <span class="fa fa-fw fa-minus-square-o toggle"></span>
        <span class="fa fa-fw fa-plus-square-o toggle"></span>
        <?php echo $title; ?>
    </div>

    <div class="panel-body">
        <?php echo $body; ?>
    </div>
</div>
