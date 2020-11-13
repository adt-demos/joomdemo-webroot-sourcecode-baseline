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

class WallFactoryFrontendModelWall extends WallFactoryFrontendModelPosts
{
    public function findOne($id)
    {
        $dbo = $this->getDbo();
        $profile = WallFactoryTable::getInstance('Profile');

        $query = $dbo->getQuery(true)
            ->select('p.*')
            ->from($dbo->qn($profile->getTableName(), 'p'))
            ->where($dbo->qn('p.user_id') . ' = ' . $dbo->q($id));

        $result = $dbo->setQuery($query)
            ->loadObject();

        return $result;
    }

    public function fetch($userId, $offset = 0, $limit = 10, $timestamp = null)
    {
        $dbo = $this->getDbo();
        $query = $this->getPostsQuery();

        if ($userId) {
            $query->where($dbo->qn('p.to_user_id') . ' = ' . $dbo->q($userId));
        }

        if ($timestamp) {
            $query->where($dbo->qn('p.created_at') . ' > ' . $dbo->q($timestamp));
        }

        $results = $dbo->setQuery($query, $offset, $limit)
            ->loadObjectList();

        return $this->parse($results);
    }

    public function count($userId)
    {
        $dbo = $this->getDbo();
        $post = WallFactoryTable::getInstance('Post');

        $query = $dbo->getQuery(true)
            ->from($dbo->qn($post->getTableName(), 'p'))
            ->where($dbo->qn('p.published') . ' = ' . $dbo->q(1));

        $query->select('COUNT(1)');

        if ($userId) {
            $query->where($dbo->qn('p.to_user_id') . ' = ' . $dbo->q($userId));
        }

        $result = $dbo->setQuery($query)
            ->loadResult();

        return $result;
    }
}
