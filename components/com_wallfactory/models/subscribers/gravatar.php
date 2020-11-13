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

class WallFactoryEventSubscriberGravatar extends \Joomla\Event\Event
{
    public static function onProfileUpdated($context, $profile = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $profile) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context || !$profile instanceof WallFactoryTableProfile) {
            return null;
        }

        if ('gravatar' !== $profile->avatar_source) {
            return null;
        }

        $user = JFactory::getUser($profile->user_id);

        $profile->save(array(
            'thumbnail' => md5(strtolower(trim($user->email))),
        ));

        return null;
    }
}
