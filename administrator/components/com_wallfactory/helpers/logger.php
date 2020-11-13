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

class WallFactoryLogger
{
    public static function log($message, $category, $priority = JLog::INFO)
    {
        JLog::add($message, $priority, $category);

        return true;
    }

    public static function registerLogger($categories, $debug = null)
    {
        if (null === $debug) {
            $debug = (boolean)JComponentHelper::getParams('com_wallfactory')->get('debug.enabled', 0);
        }

        if (false === $debug) {
            return false;
        }

        if (!is_array($categories)) {
            $categories = array($categories);
        }

        foreach ($categories as $category) {
            JLog::addLogger(
                array('text_file' => 'com_wallfactory.' . $category . '.php'),
                JLog::ALL,
                array($category)
            );
        }

        return true;
    }
}
