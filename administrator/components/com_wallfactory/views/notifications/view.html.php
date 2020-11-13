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

class WallFactoryBackendViewNotifications extends WallFactoryViewList
{
    protected $types;
    protected $groupNotifications;
    protected $configuration;

    public function display($tpl = null)
    {
        $this->types = WallFactoryNotification::getTypes();
        $this->configuration = JComponentHelper::getParams('com_wallfactory');
        $this->groupNotifications = WallFactoryNotification::getGroupNotifications();

        parent::display($tpl);

        JToolbarHelper::custom(
            $this->getName() . '.test',
            'mail',
            'mail',
            WallFactoryText::_('notifications_test_notifications')
        );
    }
}
