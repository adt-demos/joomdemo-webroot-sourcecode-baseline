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

class WallFactoryFrontendModelSearch extends WallFactoryFrontendModelPosts
{
    public function fetchAll($search = '', $limit = 10, $offset = 0)
    {
        $dbo = $this->getDbo();
        $query = $this->getQuery($search);

        $results = $dbo->setQuery($query, $offset, $limit)
            ->loadObjectList();

        return $this->parse($results);
    }

    private function getQuery($search = '')
    {
        $query = $this->getPostsQuery();

        if ('' !== $search) {
            $query->where($query->qn('content') . ' LIKE ' . $query->q('%' . $search . '%'));
        }

        return $query;
    }

    public function count($search = '')
    {
        $dbo = $this->getDbo();
        $query = $this->getQuery($search);

        $query
            ->clear('select')
            ->clear('order')
            ->select('COUNT(1)');

        $result = $dbo->setQuery($query)
            ->loadResult();

        return $result;
    }
}
