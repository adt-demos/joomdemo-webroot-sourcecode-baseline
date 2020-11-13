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

class WallFactoryDashboard
{
    private static $option = null;
    private static $dashboardLayout = 'layouts.dashboard.dashboard';
    private static $panelLayout = 'layouts.dashboard.panel';
    private static $rendererDashboard = null;
    private static $rendererPanel = null;
    private static $cacheablePanels = array(
        'user_most_active' => 60,
        'statistics'       => 5,
    );

    public static function renderDashboard()
    {
        JHtml::_('jQuery.ui', array('core', 'sortable'));

        JHtml::stylesheet('media/' . self::getOption() . '/assets/font-awesome/css/font-awesome.min.css');
        JHtml::stylesheet('media/' . self::getOption() . '/assets/dashboard/stylesheet.css');

        JHtml::script('media/' . self::getOption() . '/assets/cookies/js.cookie.js');
        JHtml::script('media/' . self::getOption() . '/assets/dashboard/script.js');

        $layout = self::getRendererDashboard();

        return $layout->render(array(
            'setup'         => self::getSetup(),
            'rendererPanel' => self::getRendererPanel(),
            'option'        => self::getOption(),
        ));
    }

    private static function getOption()
    {
        if (null === self::$option) {
            self::$option = strtolower('com_' . str_replace('Dashboard', '', __CLASS__));
        }

        return self::$option;
    }

    private static function getRendererDashboard()
    {
        if (null === self::$rendererDashboard) {
            self::$rendererDashboard = new JLayoutFile(self::$dashboardLayout, __DIR__);
        }

        return self::$rendererDashboard;
    }

    private static function getSetup()
    {
        $setup = JFactory::getApplication()->input->cookie->get(
            self::getOption() . '_dashboard',
            self::getDefaultSetup(),
            'string'
        );

        if (is_string($setup)) {
            $array = json_decode($setup);
            $setup = array();

            foreach ($array as $panel) {
                $setup[$panel->column][$panel->panel] = $panel->status;
            }
        }

        return $setup;
    }

    private static function getDefaultSetup($state = 'open')
    {
        jimport('joomla.filesystem.folder');

        $panels = JFolder::files(__DIR__ . '/../views/dashboard/panel', '.php');
        $array = array();

        foreach ($panels as $panel) {
            $array[pathinfo($panel, PATHINFO_FILENAME)] = $state;
        }

        return array_chunk($array, round(count($array) / 2), true);
    }

    private static function getRendererPanel()
    {
        if (null === self::$rendererPanel) {
            self::$rendererPanel = new JLayoutFile(self::$panelLayout, __DIR__);
        }

        return self::$rendererPanel;
    }

    public static function renderPanel($panel)
    {
        $layout = new JLayoutFile($panel, __DIR__ . '/../views/dashboard/panel');

        if (JDEBUG || !array_key_exists($panel, self::$cacheablePanels)) {
            $render = $layout->render();
            return $render;
        }

        $cache = new JCache(array(
            'caching'      => true,
            'lifetime'     => self::$cacheablePanels[$panel],
            'defaultgroup' => 'com_wallfactory.dashboard',
        ));

        $output = $cache->get($panel);

        if (!$output) {
            $output = $layout->render();
            $cache->store($output, $panel);
        }

        return $output;
    }

    public static function reset()
    {
        JFactory::getApplication()->input->cookie->set(
            self::getOption() . '_dashboard',
            '',
            time() - 24 * 60 * 60,
            '/'
        );
    }
}
