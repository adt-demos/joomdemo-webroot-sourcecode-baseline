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

class WallFactoryEventSubscriberPost extends \Joomla\Event\Event
{
    public static function onProfileRemoved($context, $profile = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $profile) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context || !$profile instanceof WallFactoryTableProfile) {
            return null;
        }

        $postRepo = new WallFactoryFrontendModelPosts();
        $posts = $postRepo->findAllByUser($profile->user_id);

        $message = $posts
            ? sprintf('Removing profile %d posts: %s', $profile->user_id, implode(', ', array_keys($posts)))
            : sprintf('Profile %d has no posts.', $profile->user_id);

        WallFactoryLogger::log($message, 'entity');

        foreach ($posts as $post) {
            $post->delete();
        }

        return null;
    }
}
