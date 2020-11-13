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

class WallFactoryFrontendModelBookmarks extends JModelLegacy
{
    public function findAll()
    {
        $dbo = $this->getDbo();
        $bookmark = WallFactoryTable::getInstance('Bookmark');

        $query = $dbo->getQuery(true)
            ->select('b.*')
            ->from($dbo->qn($bookmark->getTableName(), 'b'))
            ->where($dbo->qn('b.published') . ' = ' . $dbo->q(1))
            ->order($dbo->qn('b.ordering') . ' DESC');

        $results = $dbo->setQuery($query)
            ->loadObjectList();

        return $results;
    }
}
