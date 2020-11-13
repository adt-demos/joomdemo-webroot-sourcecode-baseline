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

class WallFactoryEventSubscriberComment extends \Joomla\Event\Event
{
    public static function onPostRemoved($context, $post = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $post) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$post instanceof WallFactoryTablePost) {
            return null;
        }

        $commentsRepo = new WallFactoryFrontendModelComments();
        $comments = $commentsRepo->findByPost($post->id);

        $message = $comments
            ? sprintf('Removing post %d comments: %s', $post->id, implode(', ', array_keys($comments)))
            : sprintf('Post %d has no comments.', $post->id);

        WallFactoryLogger::log($message, 'entity');

        foreach ($comments as $comment) {
            $comment->delete();
        }

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

        $repo = new WallFactoryFrontendModelComments();
        $comments = $repo->findByUser($profile->user_id);

        $message = $comments
            ? sprintf('Removing profile %d comments: %s', $profile->user_id, implode(', ', array_keys($comments)))
            : sprintf('Profile %d has no comments.', $profile->user_id);

        WallFactoryLogger::log($message, 'entity');

        foreach ($comments as $comment) {
            $comment->delete();
        }

        return null;
    }
}
