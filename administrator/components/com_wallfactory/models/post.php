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

class WallFactoryBackendModelPost extends WallFactoryModelAdmin
{
    public function save($data)
    {
        if ('guest' === $data['type']) {
            $data['user_id'] = 0;

            if ('' === $data['author_name']) {
                $data['author_name'] = 'Anonymous';
            }
        }
        else {
            $data['author_name'] = $data['author_email'] = '';

            if (!$data['user_id']) {
                $data['user_id'] = JFactory::getUser()->id;
            }
        }

        return parent::save($data);
    }

    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);

        if ($data instanceof JObject) {
            $data = $data->getProperties();
        }

        $type = !isset($data['user_id']) || !$data['user_id'] ? 'guest' : 'user';

        $form->setValue('type', null, $type);
    }
}
