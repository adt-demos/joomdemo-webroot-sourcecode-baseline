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

class WallFactoryBackendViewDashboard extends WallFactoryBackendView
{
    protected function prepareDocument()
    {
        parent::prepareDocument();

        JToolbarHelper::custom(
            $this->getName() . '.reset',
            'refresh',
            'refresh',
            WallFactoryText::_($this->getName() . '_reset'),
            false
        );

        JToolbarHelper::custom(
            'redirect.configuration',
            'cog',
            'cog',
            WallFactoryText::_('submenu_configuration'),
            false
        );

        JToolbarHelper::custom(
            'redirect.about',
            'info',
            'info',
            WallFactoryText::_('submenu_about'),
            false
        );
    }
}
