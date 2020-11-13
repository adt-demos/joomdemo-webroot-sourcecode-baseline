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

class WallFactoryEventSubscriberNotification extends \Joomla\Event\Event
{
    public static function getSubscribedEvents()
    {
        return array(
            'onCommentStored',
            'onPostStored',
        );
    }

    public static function onCommentStored($context, $comment = null, $isNew = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $comment, $isNew) = $context->getArguments();
        }

        if (JFactory::getApplication()->isClient('administrator') ||
            'com_wallfactory' !== $context ||
            !$isNew ||
            !$comment instanceof WallFactoryTableComment) {
            return null;
        }

        $notification = new \ThePhpFactory\Wall\Notification\CommentNew();
        $notification->setComment($comment);

        WallFactoryNotification::sendNotification($notification);

        $notification = new \ThePhpFactory\Wall\Notification\CommentNewGroup();
        $notification->setComment($comment);

        WallFactoryNotification::sendNotification($notification);

        return null;
    }

    public static function onPostStored($context, $post = null, $isNew = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $post, $isNew) = $context->getArguments();
        }

        if (JFactory::getApplication()->isClient('administrator') ||
            'com_wallfactory' !== $context ||
            !$isNew ||
            !$post instanceof WallFactoryTablePost) {
            return null;
        }

        $notification = new \ThePhpFactory\Wall\Notification\PostNewGroup();
        $notification->setPost($post);

        WallFactoryNotification::sendNotification($notification);

        return null;
    }
}
