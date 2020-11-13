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

<div class="row-fluid row">
    <?php if ($this->sidebar): ?>
        <div id="j-sidebar-container" class="span2 col-2">
            <?php echo $this->sidebar; ?>
        </div>
    <?php endif; ?>

    <div id="j-main-container"
         class="<?php echo $this->sidebar ? 'span10 col-10' : 'span12 col-12'; ?> view-<?php echo $this->getName(); ?>">
        <form action="<?php echo WallFactoryRoute::view($this->getName() . '&layout=edit&id=' . (int)$this->item->id); ?>"
              method="post" name="adminForm" id="adminForm" class="form-validate"
              enctype="<?php echo $this->form->getAttribute('enctype'); ?>">

            <div class="row-fluid row">
                <div class="span6 col-6">
                    <?php if (isset($this->setup['left'])): ?>
                        <?php foreach ($this->setup['left'] as $fieldset): ?>
                            <h2><?php echo WallFactoryText::_($this->getName() . '_fieldset_' . $fieldset); ?></h2>
                            <?php echo $this->form->renderFieldset($fieldset); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="span6 col-6">
                    <?php if (isset($this->setup['right'])): ?>
                        <?php foreach ($this->setup['right'] as $fieldset): ?>
                            <h2><?php echo WallFactoryText::_($this->getName() . '_fieldset_' . $fieldset); ?></h2>
                            <?php echo $this->form->renderFieldset($fieldset); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <input type="hidden" name="task" value=""/>
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
</div>
