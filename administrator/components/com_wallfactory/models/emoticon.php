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

class WallFactoryBackendModelEmoticon extends WallFactoryModelAdmin
{
    public function save($data)
    {
        \Joomla\CMS\Factory::getApplication()->triggerEvent('onEmoticonBeforeSave', array(
            'com_wallfactory',
            $data,
        ));

        if (!parent::save($data)) {
            return false;
        }

        $data['id'] = $this->getState($this->getName() . '.id');

        \Joomla\CMS\Factory::getApplication()->triggerEvent('onEmoticonAfterSave', array(
            'com_wallfactory',
            $data,
        ));

        return true;
    }

    protected function prepareTable($table)
    {
        if (empty($table->id)) {
            $table->ordering = $table->getNextOrder();
        }
    }

    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);

        if (is_array($data)) {
            $data = new JObject($data);
        }

        if (in_array($data->get('filename'), array('', null), true)) {
            $form->setFieldAttribute('file', 'required', 'required');
        }
        else {
            $form->setFieldAttribute('file', 'required', false);
        }
    }
}
