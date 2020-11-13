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

class WallFactoryRoute
{
    private static $option = null;

    public static function _()
    {
        $params = func_get_args();

        $params[0] = 'index.php?option=' . self::getOption() . '&' . $params[0];
        $params[1] = false;
        $params[2] = 0;

        return call_user_func_array(array('JRoute', '_'), $params);
    }

    private static function getOption()
    {
        if (null === self::$option) {
            self::$option = strtolower('com_' . str_replace('Route', '', __CLASS__));
        }

        return self::$option;
    }

    public static function view()
    {
        $params = func_get_args();

        $params[0] = 'index.php?option=' . self::getOption() . '&view=' . $params[0];
        $params[1] = false;
        $params[2] = 0;

        return call_user_func_array(array('JRoute', '_'), $params);
    }

    public static function raw()
    {
        $params = func_get_args();

        $params[0] = 'index.php?option=' . self::getOption() . '&format=raw&task=' . $params[0];
        $params[1] = false;
        $params[2] = 0;

        return call_user_func_array(array('JRoute', '_'), $params);
    }

    public static function wall(JUser $user, $user_id)
    {
        if ($user->id == $user_id) {
            return self::task('wall.show');
        }

        return self::task('wall.show&user_id=' . $user_id);
    }

    public static function task()
    {
        $params = func_get_args();

        $params[0] = 'index.php?option=' . self::getOption() . '&task=' . $params[0];
        $params[1] = false;

        if (!isset($params[2])) {
            $params[2] = 0;
        }

        return call_user_func_array(array('JRoute', '_'), $params);
    }
}
