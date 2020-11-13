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

abstract class WallFactoryModelAdmin extends JModelAdmin
{
    public function __construct(array $config)
    {
        parent::__construct($config);

        preg_match('/(.*)BackendModel(.*)/', get_class($this), $matches);

        $this->option = strtolower('com_' . $matches[1]);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm(
            $this->option . '.' . $this->getName(),
            $this->getName(),
            array(
                'control'   => 'jform',
                'load_data' => $loadData,
            )
        );

        if (!$form) {
            return false;
        }

        return $form;
    }

    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);

        WallFactoryForm::addLabelsToForm($form);
    }

    public function getTable($name = '', $prefix = '', $options = array())
    {
        if ('' === $name) {
            $name = $this->getName();
        }

        if ('' === $prefix) {
            preg_match('/(.*)BackendModel/', get_class($this), $matches);
            $prefix = $matches[1] . 'Table';
        }

        return parent::getTable($name, $prefix, $options);
    }

    protected function loadFormData()
    {
        $app = JFactory::getApplication();
        $data = $app->getUserState($this->option . '.edit.' . $this->getName() . '.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }
}
