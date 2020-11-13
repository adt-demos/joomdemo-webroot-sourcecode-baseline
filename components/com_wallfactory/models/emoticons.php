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

class WallFactoryFrontendModelEmoticons extends JModelLegacy
{
    public function fetchAll()
    {
        $dbo = $this->getDbo();

        $query = $dbo->getQuery(true)
            ->select('e.id, e.title, e.filename')
            ->from('#__com_wallfactory_emoticons AS e')
            ->where('e.published = ' . $dbo->q(1));
        $results = $dbo->setQuery($query)
            ->loadAssocList('id');

        return $results;
    }
}
