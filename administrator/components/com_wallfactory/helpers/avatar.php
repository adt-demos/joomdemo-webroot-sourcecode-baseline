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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;

class WallFactoryAvatar
{
    public static function canUploadAvatar()
    {
        if (Factory::getUser()->guest) {
            return false;
        }

        $config = ComponentHelper::getParams('com_wallfactory');
        $configAvatarSource = $config->get('profile.avatar_source', 'user_chosen');

        if ($configAvatarSource === 'user_chosen') {
            return true;
        }

        if ($configAvatarSource === 'thumbnail') {
            return true;
        }

        return false;
    }

    public static function canChangeAvatarSource($userId)
    {
        if (!$userId) {
            return false;
        }

        $config = ComponentHelper::getParams('com_wallfactory');
        $configAvatarSource = $config->get('profile.avatar_source', 'user_chosen');

        if ($configAvatarSource === 'user_chosen') {
            return true;
        }

        return false;
    }

    public static function configurationAvatarSource()
    {
        $config = ComponentHelper::getParams('com_wallfactory');

        return $config->get('profile.avatar_source', 'user_chosen');
    }
}
