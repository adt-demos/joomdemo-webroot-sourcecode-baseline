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

use Joomla\Utilities\ArrayHelper;

class WallFactoryBackendControllerNotifications extends WallFactoryControllerAdmin
{
    public function test()
    {
        $cid = JFactory::getApplication()->input->get('cid', array(), 'array');

        if (empty($cid)) {
            JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
        }
        else {
            /** @var WallFactoryBackendModelNotification $model */
            $model = $this->getModel();
            $user = JFactory::getUser();

            // Make sure the item ids are integers.
            ArrayHelper::toInteger($cid);

            // Test the notifications.
            try {
                $model->test($cid, $user->email);

                $ntext = $this->text_prefix . '_N_NOTIFICATIONS_TESTED';
                $this->setMessage(JText::plural($ntext, count($cid), $user->email));
            } catch (Exception $e) {
                $this->setMessage($e->getMessage(), 'error');
            }
        }

        $extension = $this->input->get('extension');
        $extensionURL = ($extension) ? '&extension=' . $extension : '';
        $this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . $extensionURL, false));
    }
}
