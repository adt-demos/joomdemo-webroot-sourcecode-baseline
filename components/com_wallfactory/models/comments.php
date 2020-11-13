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

class WallFactoryFrontendModelComments extends JModelLegacy
{
    public function getItems($postId, $limit = 5, $timestamp = null, $direction = 'newer')
    {
        $dbo = $this->getDbo();
        $comment = WallFactoryTable::getInstance('Comment');
        $profile = WallFactoryTable::getInstance('Profile');

        $query = $dbo->getQuery(true)
            ->select('c.*')
            ->from($dbo->qn($comment->getTableName(), 'c'))
            ->order($dbo->qn('c.created_at') . ' DESC');

        $query->select('p.avatar_source, p.thumbnail, p.name AS profile_name')
            ->leftJoin($dbo->qn($profile->getTableName(), 'p') . ' ON p.user_id = c.user_id');

        $this->filterItems($query, $postId, $timestamp, $direction);

        $results = $dbo->setQuery($query, 0, $limit)
            ->loadObjectList();

        return $results;
    }

    private function filterItems(JDatabaseQuery $query, $postId, $timestamp = null, $direction = 'newer')
    {
        $query->where($query->qn('c.published') . ' = ' . $query->q(1))
            ->where($query->qn('c.post_id') . ' = ' . $query->q($postId));

        if (null !== $timestamp) {
            $operand = 'newer' === $direction ? '>' : '<';
            $query->where($query->qn('c.created_at') . ' ' . $operand . ' ' . $query->q($timestamp));
        }
    }

    public function count($postId, $timestamp = null, $direction = 'newer')
    {
        $dbo = $this->getDbo();
        $comment = WallFactoryTable::getInstance('Comment');

        $query = $dbo->getQuery(true)
            ->select('COUNT(1)')
            ->from($dbo->qn($comment->getTableName(), 'c'));

        $this->filterItems($query, $postId, $timestamp, $direction);

        $result = $dbo->setQuery($query)
            ->loadResult();

        return $result;
    }

    public function findByPost($id)
    {
        $dbo = $this->getDbo();
        $comment = WallFactoryTable::getInstance('Comment');

        $query = $dbo->getQuery(true)
            ->select('c.*')
            ->from($dbo->qn($comment->getTableName(), 'c'))
            ->where($dbo->qn('post_id') . ' = ' . $dbo->q($id));

        $results = $dbo->setQuery($query)
            ->loadObjectList('id', get_class($comment));

        return $results;
    }

    public function findByUser($id)
    {
        $dbo = $this->getDbo();
        $comment = WallFactoryTable::getInstance('Comment');

        $query = $dbo->getQuery(true)
            ->select('c.*')
            ->from($dbo->qn($comment->getTableName(), 'c'))
            ->where($dbo->qn('c.user_id') . ' = ' . $dbo->q($id));

        $results = $dbo->setQuery($query)
            ->loadObjectList('id', get_class($comment));

        return $results;
    }

    public function findById($id)
    {
        $dbo = $this->getDbo();
        $comment = WallFactoryTable::getInstance('Comment');
        $profile = WallFactoryTable::getInstance('Profile');

        $query = $dbo->getQuery(true)
            ->select('c.*')
            ->from($dbo->qn($comment->getTableName(), 'c'))
            ->where($dbo->qn('c.id') . ' = ' . $dbo->q($id));

        $query->select('p.avatar_source, p.thumbnail, p.name AS profile_name')
            ->leftJoin($dbo->qn($profile->getTableName(), 'p') . ' ON p.user_id = c.user_id');

        $result = $dbo->setQuery($query)
            ->loadObject();

        return $result;
    }
}
