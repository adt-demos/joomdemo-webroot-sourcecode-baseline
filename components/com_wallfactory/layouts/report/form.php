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

<div class="wallfactory-view">
    <div class="modal report-modal" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo WallFactoryRoute::raw('report.submit'); ?>" method="post">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <?php echo WallFactoryText::_('report_modal_title'); ?>
                        </h3>
                    </div>

                    <div class="modal-body">
                        <?php echo $form->renderFieldset('details'); ?>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link" data-dismiss="modal">
                            <?php echo WallFactoryText::_('report_modal_button_cancel'); ?>
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <?php echo WallFactoryText::_('report_modal_button_submit'); ?>
                        </button>

                        <a href="#" class="btn btn-primary" style="display: none;" data-dismiss="modal">
                            <?php echo WallFactoryText::_('report_modal_button_close'); ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
