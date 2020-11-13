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

extract($displayData);

?>

<div class="row-fluid columns dashboard row" data-option="<?php echo $option; ?>">
    <?php foreach (range(0, 1) as $column): ?>
        <div class="span6 sortable col-6">
            <?php if (isset($setup[$column])): ?>
                <?php foreach ($setup[$column] as $panel => $state): ?>

                    <?php echo $rendererPanel->render(array(
                        'id'    => $panel,
                        'title' => WallFactoryText::_('dashboard_panel_heading_' . $panel),
                        'body'  => WallFactoryDashboard::renderPanel($panel),
                        'state' => $state,
                    )); ?>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
