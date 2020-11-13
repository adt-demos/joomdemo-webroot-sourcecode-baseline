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

abstract class WallFactoryViewForm extends WallFactoryBackendView
{
    protected $item;
    protected $form;
    protected $setup;

    public function display($tpl = null)
    {
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');
        $this->setup = WallFactoryForm::getSetup($this->form, false);

        $this->_path['template'][] = __DIR__ . '/tmpl';

        return parent::display($tpl);
    }

    protected function prepareDocument()
    {
        if ($this->item->id) {
            JToolbarHelper::title(
                WallFactoryText::sprintf(
                    $this->getName() . '_view_page_title_edit',
                    $this->item->id,
                    $this->getItemTitle($this->item)
                )
            );
        }
        else {
            JToolbarHelper::title(
                WallFactoryText::_($this->getName() . '_view_page_title_new')
            );
        }

        JToolbarHelper::apply($this->getName() . '.apply');
        JToolbarHelper::save($this->getName() . '.save');
        JToolbarHelper::cancel($this->getName() . '.cancel');
    }

    private function getItemTitle(JObject $item)
    {
        $titles = array(
            'title',
            'subject',
        );

        $properties = $item->getProperties();

        foreach ($properties as $key => $value) {
            if (in_array($key, $titles)) {
                return $value;
            }
        }

        return 'Untitled';
    }
}
