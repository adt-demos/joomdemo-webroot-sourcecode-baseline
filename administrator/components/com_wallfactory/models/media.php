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

class WallFactoryBackendModelMedia extends JModelLegacy
{
    public function getTotals()
    {
        $dbo = $this->getDbo();
        $media = WallFactoryTable::getInstance('Media');

        $query = $dbo->getQuery(true)
            ->select('COUNT(1) AS total, media_type')
            ->from($dbo->qn($media->getTableName()))
            ->group($dbo->qn('media_type'));

        $results = $dbo->setQuery($query)
            ->loadAssocList('media_type');

        return $results;
    }

    public function count($resource)
    {
        $dbo = $this->getDbo();
        $table = WallFactoryTable::getInstance('Media' . $resource);

        $query = $dbo->getQuery(true)
            ->select('COUNT(1)')
            ->from($dbo->qn($table->getTableName()));

        return $dbo->setQuery($query)
            ->loadResult();
    }
}
