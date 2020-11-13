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

class WallFactoryBackendModelUser extends WallFactoryModelAdmin
{
    public function getForm($data = array(), $loadData = true)
    {
        JFactory::getLanguage()->load('com_wallfactory', JPATH_SITE);

        JForm::addFormPath(JPATH_SITE . '/components/com_wallfactory/models/forms');
        JForm::addFieldPath(JPATH_SITE . '/components/com_wallfactory/models/fields');

        $form = $this->loadForm(
            $this->option . '.' . $this->getName(),
            'profile',
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

    public function getItem($pk = null)
    {
        $pk = JFactory::getApplication()->input->getInt('id');

        return parent::getItem($pk);
    }

    public function save($data)
    {
        $id = JFactory::getApplication()->input->getInt('id');
        $this->setState($this->getName() . '.id', $id);

        if (!parent::save($data)) {
            return false;
        }

        $profile = $this->getTable();
        $profile->load($id);

        \Joomla\CMS\Factory::getApplication()->triggerEvent('onProfileUpdated', array(
            'com_wallfactory',
            $profile,
        ));

        return true;
    }

    public function getTable($name = 'Profile', $prefix = '', $options = array())
    {
        return parent::getTable($name, $prefix, $options);
    }

    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);

        $form->setFieldAttribute('description', 'rows', 10);
        $form->removeField('user_id');
    }
}
