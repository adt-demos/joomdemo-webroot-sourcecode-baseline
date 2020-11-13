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

class WallFactoryEvent
{
    public static function registerSubscribers()
    {
        JDEBUG ? JProfiler::getInstance('Application')->mark('Start &mdash; WallFactoryEvent::registerSubscribers()') : null;

        jimport('joomla.filesystem.folder');

        $name = str_replace('Event', '', __CLASS__);
        $option = strtolower('com_' . $name);

        $listeners = JFolder::files(JPATH_SITE . '/components/' . $option . '/models/subscribers', '.php');

        foreach ($listeners as $listener) {
            require_once JPATH_SITE . '/components/' . $option . '/models/subscribers/' . $listener;

            $listener = pathinfo($listener, PATHINFO_FILENAME);

            $class = $name . 'EventSubscriber' . ucfirst($listener);

            if (method_exists($class, 'getSubscribedEvents')) {
                $events = $class::getSubscribedEvents();

                foreach ($events as $event) {
                    \Joomla\CMS\Factory::getApplication()->registerEvent($event, array($class, $event));
                }
            }
            else {
                foreach (get_class_methods($class) as $method) {
                    if (0 === strpos($method, 'on')) {
                        \Joomla\CMS\Factory::getApplication()->registerEvent($method, array($class, $method));
                    }
                }
            }
        }

        JDEBUG ? JProfiler::getInstance('Application')->mark('Finish &mdash; WallFactoryEvent::registerSubscribers()') : null;
    }
}
