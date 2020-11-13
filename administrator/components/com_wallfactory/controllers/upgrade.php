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

class WallFactoryBackendControllerUpgrade extends JControllerLegacy
{
    public function restore()
    {
        WallFactoryUpgrade::restore();

        JFactory::getApplication()->enqueueMessage('Success!', 'info');
        JFactory::getApplication()->redirect(WallFactoryRoute::view('dashboard'));
    }

    public function delete()
    {
        WallFactoryUpgrade::delete();

        JFactory::getApplication()->enqueueMessage('Success!', 'info');
        JFactory::getApplication()->redirect(WallFactoryRoute::view('dashboard'));
    }
}
