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

abstract class WallFactoryBackendView extends JViewLegacy
{
    protected $option;
    protected $sidebar;
    protected $inflector;
    protected $input;

    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->inflector = \Joomla\String\Inflector::getInstance();

        preg_match('/(.*)BackendView(.*)/', get_class($this), $matches);

        $this->option = strtolower('com_' . $matches[1]);
        $this->input = JFactory::getApplication()->input;
    }

    public function display($tpl = null)
    {
        $this->prepareDocument();

        WallFactoryHelper::addSubmenu($this->getName());
        $this->sidebar = JHtmlSidebar::render();

        $help = new WallFactoryHelp();
        $help->render($this->getName());

        $this->beforeDisplay();

        $version = (int)\Joomla\CMS\Version::MAJOR_VERSION;
        \Joomla\CMS\HTML\HTMLHelper::stylesheet('media/com_wallfactory/assets/common/migration' . $version . '.css');

        return parent::display($tpl);
    }

    protected function prepareDocument()
    {
        JToolBarHelper::title(WallFactoryText::_('submenu_' . $this->getName()));
    }

    protected function beforeDisplay()
    {
    }
}
