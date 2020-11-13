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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
if (3 === (int)\Joomla\CMS\Version::MAJOR_VERSION) {
    JHtml::_('formbehavior.chosen', 'select');
}

JHtml::stylesheet('media/' . $this->option . '/assets/font-awesome/css/font-awesome.min.css');
JHtml::stylesheet('media/' . $this->option . '/assets/backend/stylesheet.css');

if ($this->saveOrder) {
    JHtml::_(
        'sortablelist.sortable',
        $this->getName() . 'List',
        'adminForm',
        strtolower($this->listDirn),
        WallFactoryRoute::raw($this->getName() . '.saveOrderAjax')
    );
}

?>

<div class="row-fluid row">
    <?php if ($this->sidebar): ?>
        <div id="j-sidebar-container" class="span2 col-2">
            <?php echo $this->sidebar; ?>
        </div>
    <?php endif; ?>

    <div id="j-main-container"
         class="<?php echo $this->sidebar ? 'span10 col-10' : 'span12 col-12'; ?> view-<?php echo $this->getName(); ?>">
        <form action="<?php echo WallFactoryRoute::view($this->getName()); ?>" method="post" name="adminForm"
              id="adminForm">

            <?php echo JLayoutHelper::render('joomla.searchtools.default', array(
                'view' => $this,
            )); ?>

            <?php if (!$this->items): ?>
                <div class="alert alert-no-items">
                    <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                </div>
            <?php else: ?>
                <table class="table table-striped table-hover" id="<?php echo $this->getName(); ?>List">
                    <thead>
                    <tr>
                        <?php echo $this->loadTemplate('head'); ?>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <td colspan="10">
                        </td>
                    </tr>
                    </tfoot>

                    <tbody>
                    <?php foreach ($this->items as $this->i => $this->item): ?>
                        <tr>
                            <?php echo $this->loadTemplate('body'); ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div style="margin: 0 0 15px;">
                <?php echo $this->pagination->getResultsCounter(); ?>
            </div>
            <?php echo $this->pagination->getListFooter(); ?>

            <input type="hidden" name="task" value=""/>
            <input type="hidden" name="boxchecked" value="0"/>
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
</div>
