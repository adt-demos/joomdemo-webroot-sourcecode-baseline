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

JHtml::stylesheet('media/com_wallfactory/assets/backend/stylesheet.css');

?>

<script>
    jQuery(document).ready(function ($) {
        $('a[data-toggle="tab"]').on('shown', function (e) {
            var tab = $(e.target).attr('href').replace('#', '');
            $('input#active').val(tab);
        })
    });
</script>

<div class="row-fluid row">
    <?php if ($this->sidebar): ?>
        <div id="j-sidebar-container" class="span2 col-2">
            <?php echo $this->sidebar; ?>
        </div>
    <?php endif; ?>

    <div id="j-main-container"
         class="<?php echo $this->sidebar ? 'span10 col-10' : 'span12 col-12'; ?> view-<?php echo $this->getName(); ?>">

        <form action="<?php echo WallFactoryRoute::view($this->getName()); ?>" method="post" name="adminForm"
              id="adminForm"
              class="form-validate">

            <?php echo JHtml::_('bootstrap.startTabSet', $this->getName(), array('active' => $this->active)); ?>
            <?php foreach ($this->setup as $tab => $sides): ?>
                <?php echo JHtml::_('bootstrap.addTab', $this->getName(), $tab, WallFactoryText::_('configuration_tab_' . $tab)); ?>
                <div class="row-fluid row">
                    <div class="span6 col-6">
                        <?php if (isset($sides['left'])): ?>
                            <?php foreach ($sides['left'] as $fieldset): ?>
                                <div class="section">
                                    <h2><?php echo WallFactoryText::_('configuration_fieldset_' . $tab . '_' . $fieldset); ?></h2>
                                    <?php echo $this->form->renderFieldset($fieldset); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="span6 col-6">
                        <?php if (isset($sides['right'])): ?>
                            <?php foreach ($sides['right'] as $fieldset): ?>
                                <div class="section">
                                    <h2><?php echo WallFactoryText::_('configuration_fieldset_' . $tab . '_' . $fieldset); ?></h2>
                                    <?php echo $this->form->renderFieldset($fieldset); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php echo JHtml::_('bootstrap.endTab'); ?>
            <?php endforeach; ?>
            <?php echo JHtml::_('bootstrap.endTabSet'); ?>

            <input type="hidden" name="task" value=""/>
            <input type="hidden" name="active" id="active" value="<?php echo $this->active; ?>"/>
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
</div>
