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

class WallFactoryHelper
{
    private static $bannedWords = null;

    private static $sqlMode;

    public static function addSubmenu($view)
    {
        if (4 === (int)\Joomla\CMS\Version::MAJOR_VERSION) {
            return;
        }

        $menu = array(
            'dashboard',
            'users',
            'posts',
            'comments',
            'reports',
            'emoticons',
            'bookmarks',
            'notifications',
            'configuration',
            'about',
        );

        $params = JComponentHelper::getParams('com_wallfactory');
        $inflector = \Joomla\String\Inflector::getInstance();

        $inflector->addWord('feedback', 'list');
        $singular = $inflector->toSingular($view);
        $plural = $inflector->toPlural($view);

        // Remove unused menu items.
        if ($params->get('backend.hide_disabled_menus', 0)) {
            if (!$params->get('posting.emoticons.enabled', 1)) {
                unset($menu[array_search('emoticons', $menu)]);
            }

            if (!$params->get('bookmark.enabled', 1)) {
                unset($menu[array_search('bookmarks', $menu)]);
            }

            if (!$params->get('comment.enabled', 1)) {
                unset($menu[array_search('comments', $menu)]);
            }
        }

        foreach ($menu as $item) {
            JHtmlSidebar::addEntry(
                self::submenuText($item),
                self::submenuRoute($item),
                in_array($item, array($view, $singular, $plural)) ? true : false
            );
        }
    }

    private static function submenuText($item)
    {
        if ('reports' === $item) {
            $model = JModelLegacy::getInstance('Reports', 'WallFactoryBackendModel', array('ignore_request' => true));
            $unresolved = $model->countUnresolvedReports();

            return WallFactoryText::plural('submenu_count_' . $item, number_format($unresolved, 0));
        }

        return WallFactoryText::_('submenu_' . $item);
    }

    private static function submenuRoute($item)
    {
        return WallFactoryRoute::view($item);
    }

    public static function filterBannedWords($text)
    {
        if (null === static::$bannedWords) {
            static::$bannedWords = false;

            $configuration = \Joomla\CMS\Component\ComponentHelper::getParams('com_wallfactory');
            $banned = $configuration->get('moderation.banned.words');
            $banned = trim($banned);

            if ('' !== $banned) {
                static::$bannedWords = preg_split('/\r\n|\r|\n/', $banned);
            }
        }

        if (false === static::$bannedWords) {
            return $text;
        }

        return str_ireplace(static::$bannedWords, '***', $text);
    }

    public static function setSqlMode()
    {
        $dbo = \Joomla\CMS\Factory::getDbo();
        $query = $dbo->setQuery('SELECT @@sql_mode;');
        self::$sqlMode = $query->loadResult();
        $exploded = explode(',', self::$sqlMode);

        foreach ($exploded as $i => $value) {
            if (in_array($value, ['ONLY_FULL_GROUP_BY', 'STRICT_TRANS_TABLES'])) {
                unset($exploded[$i]);
            }
        }

        $query = $dbo->setQuery('SET sql_mode="' . implode(',', $exploded) . '"');
        $query->execute();
    }

    public static function resetSqlMode()
    {
        $dbo = \Joomla\CMS\Factory::getDbo();

        $query = $dbo->setQuery('SET sql_mode="' . self::$sqlMode . '"');
        $query->execute();
    }
}
