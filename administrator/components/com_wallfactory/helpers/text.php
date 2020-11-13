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

class WallFactoryText
{
    public static function _()
    {
        $params = func_get_args();

        $params[0] = self::prefix($params[0]);

        return call_user_func_array(array('JText', '_'), $params);
    }

    public static function prefix($string)
    {
        $option = 'com_' . str_replace('Text', '', __CLASS__);

        return strtoupper($option . '_' . $string);
    }

    public static function plural()
    {
        $params = func_get_args();

        $params[0] = self::prefix($params[0]);

        return call_user_func_array(array('JText', 'plural'), $params);
    }

    public static function sprintf()
    {
        $params = func_get_args();

        $params[0] = self::prefix($params[0]);

        return call_user_func_array(array('JText', 'sprintf'), $params);
    }
}
