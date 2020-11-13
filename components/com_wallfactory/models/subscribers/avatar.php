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

class WallFactoryEventSubscriberAvatar extends \Joomla\Event\Event
{
    public static function onProfileUpdated($context, $profile = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $profile) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context || !$profile instanceof WallFactoryTableProfile) {
            return null;
        }

        if ('thumbnail' !== $profile->avatar_source) {
            return null;
        }

        jimport('joomla.filesystem.folder');

        $avatarModel = new WallFactoryFrontendModelAvatar();
        $path = $avatarModel->getFullPath($profile->user_id);

        if (!JFolder::exists($path)) {
            return null;
        }

        $files = JFolder::files($path, 'thumbnail');

        if (!$files) {
            return null;
        }

        $thumbnail = $avatarModel->getRelativePath($profile->user_id) . '/' . $files[0];

        $profile->save(array(
            'thumbnail' => $thumbnail,
        ));

        return null;
    }

    public static function onProfileRemoved($context, $profile = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $profile) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context || !$profile instanceof WallFactoryTableProfile) {
            return null;
        }

        jimport('joomla.filesystem.folder');

        $avatarModel = new WallFactoryFrontendModelAvatar();
        $path = $avatarModel->getFullPath($profile->user_id);

        if (JFolder::exists($path)) {
            JFolder::delete($path);
        }

        return null;
    }
}
