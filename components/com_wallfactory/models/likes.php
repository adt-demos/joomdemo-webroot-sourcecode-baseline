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

class WallFactoryFrontendModelLikes extends JModelLegacy
{
    public function countForResources($type, array $ids = array())
    {
        $like = WallFactoryTable::getInstance('Like');

        if (!$ids) {
            return array();
        }

        $dbo = $this->getDbo();
        $query = $dbo->getQuery(true)
            ->select($dbo->qn('l.resource_id'))
            ->select('COUNT(1) AS likes')
            ->from($dbo->qn($like->getTableName(), 'l'))
            ->where($dbo->qn('l.resource_type') . ' = ' . $dbo->q($type))
            ->where($dbo->qn('l.resource_id') . ' IN (' . implode(',', $dbo->q($ids)) . ')')
            ->group($dbo->qn('l.resource_id'));

        $results = $dbo->setQuery($query)
            ->loadAssocList('resource_id');

        return $results;
    }

    public function findByUserForResources($userId, $type, array $ids = array())
    {
        $like = WallFactoryTable::getInstance('Like');

        if (!$userId || !$ids) {
            return array();
        }

        $dbo = $this->getDbo();
        $query = $dbo->getQuery(true)
            ->select($dbo->qn('l.resource_id'))
            ->from($dbo->qn($like->getTableName(), 'l'))
            ->where($dbo->qn('l.resource_type') . ' = ' . $dbo->q($type))
            ->where($dbo->qn('l.resource_id') . ' IN (' . implode(',', $dbo->q($ids)) . ')')
            ->where($dbo->qn('l.user_id') . ' = ' . $dbo->q($userId));

        $results = $dbo->setQuery($query)
            ->loadAssocList('resource_id');

        return $results;
    }

    public function findLikes($resource, $resourceId)
    {
        $dbo = $this->getDbo();
        $like = WallFactoryTable::getInstance('Like');
        $profile = WallFactoryTable::getInstance('Profile');

        $query = $dbo->getQuery(true)
            ->select('l.*')
            ->from($dbo->qn($like->getTableName(), 'l'))
            ->order($dbo->qn('l.created_at') . ' DESC');

        $query->where($dbo->qn('l.resource_type') . ' = ' . $dbo->q($resource))
            ->where($dbo->qn('l.resource_id') . ' = ' . $dbo->q($resourceId));

        $query->select('prf.avatar_source, prf.thumbnail, prf.name')
            ->leftJoin($dbo->qn($profile->getTableName(), 'prf') . ' ON prf.user_id = l.user_id');

        $result = $dbo->setQuery($query)
            ->loadObjectList();

        return $result;
    }

    /**
     * @param $resource
     * @param $id
     *
     * @return WallFactoryTableLike[]
     */
    public function findByResource($resource, $id)
    {
        $dbo = $this->getDbo();
        $like = WallFactoryTable::getInstance('Like');

        $query = $dbo->getQuery(true)
            ->select('l.*')
            ->from($dbo->qn($like->getTableName(), 'l'))
            ->where($dbo->qn('l.resource_type') . ' = ' . $dbo->q($resource))
            ->where($dbo->qn('l.resource_id') . ' = ' . $dbo->q($id));

        $results = $dbo->setQuery($query)
            ->loadObjectList('id', get_class($like));

        return $results;
    }
}
