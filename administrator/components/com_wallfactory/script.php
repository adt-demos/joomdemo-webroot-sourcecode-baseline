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

class com_WallFactoryInstallerScript
{
    protected $option = 'com_wallfactory';

    public function preflight($type, $parent)
    {
        if ('update' == $type) {
            $file = JPATH_ADMINISTRATOR . '/components/' . $this->option . '/wallfactory.xml';
            $data = JInstaller::parseXMLInstallFile($file);
            $this->updateSchemasTable($data);

            $this->backupBookmarksFolder();
        }

        return true;
    }

    private function updateSchemasTable($data)
    {
        $extension = JTable::getInstance('Extension', 'JTable');
        $componentId = $extension->find(array('type' => 'component', 'element' => $this->option));

        $dbo = JFactory::getDbo();
        $query = $dbo->getQuery(true)
            ->select('s.version_id')
            ->from('#__schemas s')
            ->where('s.extension_id = ' . $dbo->quote($componentId));
        $result = $dbo->setQuery($query)
            ->loadResult();

        if (!$result) {
            $query = $dbo->getQuery(true)
                ->insert('#__schemas')
                ->set('extension_id = ' . $dbo->quote($componentId))
                ->set('version_id = ' . $dbo->quote($data['version']));
        }
        else {
            $query = $dbo->getQuery(true)
                ->update('#__schemas')
                ->set('version_id = ' . $dbo->quote($data['version']))
                ->where('extension_id = ' . $dbo->quote($componentId));
        }

        $dbo->setQuery($query)
            ->execute();
    }

    private function backupBookmarksFolder()
    {
        jimport('joomla.filesystem.folder');

        $src = JPATH_ADMINISTRATOR . '/components/com_wallfactory/storage/bookmarks';

        if (!JFolder::exists($src)) {
            return true;
        }

        $dest = JPATH_SITE . '/media/com_wallfactory/backup/bookmarks';

        JFolder::copy($src, $dest);
    }

    public function postflight($type, $parent)
    {
        require_once JPATH_ADMINISTRATOR . '/components/com_wallfactory/helpers/menu.php';

        $menu = new WallFactoryMenu(JFactory::getDbo(), 'com_wallfactory');
        $menu->createFromViews();
    }
}
