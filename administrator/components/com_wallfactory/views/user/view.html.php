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

class WallFactoryBackendViewUser extends WallFactoryViewForm
{
    protected function prepareDocument()
    {
        JToolbarHelper::title(
            WallFactoryText::sprintf($this->getName() . '_view_page_title_edit', $this->item->user_id, $this->item->name)
        );

        JToolbarHelper::apply($this->getName() . '.apply');
        JToolbarHelper::save($this->getName() . '.save');
        JToolbarHelper::cancel($this->getName() . '.cancel');
    }
}
