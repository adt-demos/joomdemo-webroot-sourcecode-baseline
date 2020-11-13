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

class WallFactoryBackendViewAbout extends WallFactoryBackendView
{
    protected $aboutHelper;

    public function display($tpl = null)
    {
        $this->aboutHelper = new \ThePhpFactory\Joomla\About('wall');

        return parent::display($tpl);
    }

    protected function prepareDocument()
    {
        parent::prepareDocument();

        JToolbarHelper::custom(
            'redirect.dashboard',
            'dashboard',
            'dashboard',
            WallFactoryText::_('submenu_dashboard'),
            false
        );

        JToolbarHelper::custom(
            'redirect.configuration',
            'cog',
            'cog',
            WallFactoryText::_('submenu_configuration'),
            false
        );
    }
}
