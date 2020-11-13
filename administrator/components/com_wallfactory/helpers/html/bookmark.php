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

class JHtmlWallFactoryBookmark
{
    public static function src($thumbnail)
    {
        $path = JPATH_SITE . '/media/com_wallfactory/bookmarks/' . $thumbnail;

        if (file_exists($path) && is_file($path)) {
            return JUri::root() . 'media/com_wallfactory/bookmarks/' . $thumbnail;
        }

        return JUri::root() . 'media/com_wallfactory/bookmarks/default.png';
    }
}
