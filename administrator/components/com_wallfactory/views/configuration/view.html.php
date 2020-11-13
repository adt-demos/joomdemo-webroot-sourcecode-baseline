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

class WallFactoryBackendViewConfiguration extends WallFactoryBackendView
{
    protected $option = 'com_wallfactory';
    protected $form;
    protected $setup;
    protected $active;

    public function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->active = $this->input->getCmd('active', 'general');
        $this->setup = WallFactoryForm::getSetup($this->form);

        WallFactoryForm::bindContextData($this->form, JComponentHelper::getParams($this->option));

        return parent::display($tpl);
    }

    protected function prepareDocument()
    {
        parent::prepareDocument();

        JToolbarHelper::apply($this->getName() . '.apply');
        JToolbarHelper::save($this->getName() . '.save');
        JToolbarHelper::cancel($this->getName() . '.cancel');
    }
}
