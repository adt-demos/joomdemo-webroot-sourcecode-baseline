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

class WallFactoryMenu
{
    private $dbo;
    private $component;
    private $componentId = null;

    public function __construct(JDatabaseDriver $dbo, $component)
    {
        $this->dbo = $dbo;
        $this->component = $component;
    }

    public function createFromViews()
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $path = JPATH_SITE . '/components/' . $this->component . '/views';
        $items = JFolder::folders($path);
        rsort($items);
        $type = str_replace('com_', '', $this->component);
        $title = ucwords(implode(' ', explode('-', $type)));

        if ($this->exists($type)) {
            return true;
        }

        $this->create($type, $title);
        $this->createModule($type, $title);

        JFactory::getLanguage()->load($this->component . '.sys', JPATH_ADMINISTRATOR, 'en-GB', true);

        foreach ($items as $view) {
            if (!JFile::exists($path . '/' . $view . '/tmpl/default.xml')) {
                continue;
            }

            $xml = simplexml_load_file($path . '/' . $view . '/tmpl/default.xml');
            $title = JText::_(strtoupper($xml->layout['title']));

            $this->addItem($view, $type, $title);
        }
    }

    public function exists($type)
    {
        $menu = JTable::getInstance('MenuType');

        return $menu->load(array(
            'menutype' => $type,
        ));
    }

    public function create($type, $title, $description = null)
    {
        $menu = JTable::getInstance('MenuType');

        return $menu->save(array(
            'menutype'    => $type,
            'title'       => $title,
            'description' => $description,
        ));
    }

    public function createModule($type, $title)
    {
        $table = JTable::getInstance('Module');

        try {
            $table->save(array(
                'title'     => $title,
                'position'  => 'position-7',
                'published' => 1,
                'module'    => 'mod_menu',
                'access'    => 1,
                'showtitle' => 1,
                'params'    => '{"menutype":"' . $type . '","startLevel":"1","endLevel":"0","showAllChildren":"0","tag_id":"","class_sfx":"","window_open":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid"}',
                'client_id' => 0,
                'language'  => '*',
            ));
        } catch (Exception $e) {
        }

        $dbo = $this->dbo;

        $query = $dbo->getQuery(true)
            ->insert($dbo->qn('#__modules_menu'))
            ->values($dbo->q($table->id) . ', ' . $dbo->q(0));

        $dbo->setQuery($query)
            ->execute();
    }

    public function addItem($view, $type, $title)
    {
        $componentId = $this->getComponentId();
        $item = JTable::getInstance('Menu');

        try {
            $item->save(array(
                'menutype'     => $type,
                'type'         => 'component',
                'published'    => 1,
                'client_id'    => 0,
                'level'        => 1,
                'parent_id'    => 1,
                'component_id' => $componentId,
                'title'        => $title,
                'alias'        => JFilterOutput::stringURLSafe($view),
                'link'         => 'index.php?option=' . $this->component . '&view=' . $view,
                'access'       => 1,
                'language'     => '*',
            ));
        } catch (Exception $e) {
        }

        $dbo = $this->dbo;
        $query = $dbo->getQuery(true)
            ->update($dbo->qn('#__menu'))
            ->set($dbo->qn('parent_id') . ' = ' . $dbo->q(1) . ', ' . $dbo->qn('level') . ' = ' . $dbo->q(1))
            ->where($dbo->qn('id') . ' = ' . $dbo->q($item->id));

        $dbo->setQuery($query)
            ->execute();
    }

    private function getComponentId()
    {
        if (null === $this->componentId) {
            $extension = JTable::getInstance('Extension');
            $this->componentId = $extension->find(array(
                'type'    => 'component',
                'element' => $this->component,
            ));
        }

        return $this->componentId;
    }
}
