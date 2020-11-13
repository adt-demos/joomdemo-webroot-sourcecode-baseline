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

class WallFactoryEventSubscriberLike extends \Joomla\Event\Event
{
    public static function getSubscribedEvents()
    {
        return array(
            'onPostRemoved',
        );
    }

    public static function onPostRemoved($context, $post = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $post) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$post instanceof WallFactoryTablePost) {
            return null;
        }

        $likeRepo = new WallFactoryFrontendModelLikes();
        $likes = $likeRepo->findByResource('post', $post->id);

        $message = $likes
            ? sprintf('Removing post %d likes: %s', $post->id, implode(', ', array_keys($likes)))
            : sprintf('Post %d has no likes.', $post->id);

        WallFactoryLogger::log($message, 'entity');

        foreach ($likes as $like) {
            $like->delete();
        }

        return null;
    }
}
