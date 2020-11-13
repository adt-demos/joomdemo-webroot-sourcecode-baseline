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

class WallFactoryBackendViewComments extends WallFactoryViewList
{
    protected function prepareDocument()
    {
        JToolBarHelper::title(WallFactoryText::_('submenu_' . $this->getName()));

        $singular = $this->inflector->toSingular($this->getName());

        JToolBarHelper::editList($singular . '.edit');

        JToolBarHelper::publishList($this->getName() . '.publish');
        JToolBarHelper::unpublishList($this->getName() . '.unpublish');

        JToolBarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', $this->getName() . '.delete');
    }
}
