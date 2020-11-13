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

class WallFactoryFrontendModelEmoticon extends JModelLegacy
{
    public function findAll()
    {
        $dbo = $this->getDbo();
        $emoticon = WallFactoryTable::getInstance('Emoticon');

        $query = $dbo->getQuery(true)
            ->select('e.id, e.filename, e.title')
            ->from($dbo->qn($emoticon->getTableName(), 'e'))
            ->where($dbo->qn('e.published') . ' = ' . $dbo->q(1))
            ->order($dbo->qn('e.ordering') . ' DESC');

        $results = $dbo->setQuery($query)
            ->loadObjectList();

        return $results;
    }
}
