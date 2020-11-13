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

class WallFactoryFrontendModelNewsFeed extends WallFactoryFrontendModelPosts
{
    public function fetch($userId, $timestamp = null, $offset = 0, $limit = 10)
    {
        $dbo = $this->getDbo();

        $userPostsSubQuery = $this->getSubQueryUserPosts($userId, $timestamp);
        $subscriptionPostsSubQuery = $this->getSubQuerySubscriptionPosts($userId, $timestamp);

        $query = '(' . $userPostsSubQuery . ') UNION (' . $subscriptionPostsSubQuery . ') ORDER BY ' . $dbo->qn('created_at') . ' DESC';

        $results = $dbo->setQuery($query, $offset, $limit)
            ->loadObjectList();

        return $this->parse($results);
    }

    private function getSubQueryUserPosts($userId, $timestamp = null)
    {
        $subscription = WallFactoryTable::getInstance('Subscription');

        $query = $this->getPostsQuery()
            ->clear('order');

        $query->select('s.id AS subscribed')
            ->leftJoin($query->qn($subscription->getTableName(), 's') . ' ON s.user_id = p.user_id AND s.subscriber_id = ' . $query->q($userId));

        $conditions = array();
        $conditions[] = $query->qn('p.to_user_id') . ' = ' . $query->q($userId);
        $conditions[] = $query->qn('p.user_id') . ' = ' . $query->q($userId);

        $query->where('(' . implode(' OR ', $conditions) . ')');

        if (null !== $timestamp) {
            $query->where($query->qn('p.created_at') . ' > ' . $query->q($timestamp));
        }

        return $query;
    }

    private function getSubQuerySubscriptionPosts($userId, $timestamp = null)
    {
        $subscription = WallFactoryTable::getInstance('Subscription');

        $query = $this->getPostsQuery()
            ->clear('order');

        $query->select('s.id AS subscribed')
            ->innerJoin($query->qn($subscription->getTableName(), 's') . ' ON s.user_id = p.user_id AND s.subscriber_id = ' . $query->q($userId));

        if (null !== $timestamp) {
            $query->where($query->qn('p.created_at') . ' > ' . $query->q($timestamp));
        }

        return $query;
    }

    public function count($userId)
    {
        $dbo = $this->getDbo();

        $userPostsSubQuery = $this->getSubQueryUserPosts($userId);
        $subscriptionPostsSubQuery = $this->getSubQuerySubscriptionPosts($userId);

        $userPostsSubQuery->clear('select')->select('p.id');
        $subscriptionPostsSubQuery->clear('select')->select('p.id');

        $query = 'SELECT COUNT(1) FROM ((' . $userPostsSubQuery . ') UNION (' . $subscriptionPostsSubQuery . ')) AS query';
        $result = $dbo->setQuery($query)
            ->loadResult();

        return (int)$result;
    }
}
