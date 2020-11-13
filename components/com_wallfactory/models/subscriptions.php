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

class WallFactoryFrontendModelSubscriptions extends JModelLegacy
{
    public function findAll($subscriberId, $limit = 0)
    {
        $dbo = $this->getDbo();
        $subscription = WallFactoryTable::getInstance('Subscription');
        $profile = WallFactoryTable::getInstance('Profile');

        $query = $dbo->getQuery(true)
            ->select('s.user_id, s.created_at, s.notification')
            ->from($dbo->qn($subscription->getTableName(), 's'))
            ->where($dbo->qn('s.subscriber_id') . ' = ' . $dbo->q($subscriberId))
            ->order($dbo->qn('s.created_at') . ' DESC');

        $query->select('p.name, p.avatar_source, p.thumbnail')
            ->leftJoin($dbo->qn($profile->getTableName(), 'p') . ' ON p.user_id = s.user_id');

        $results = $dbo->setQuery($query, 0, $limit)
            ->loadObjectList();

        return $results;
    }

    public function findByUser($id)
    {
        /** @var WallFactoryTableSubscription $subscription */

        $dbo = $this->getDbo();
        $subscription = WallFactoryTable::getInstance('Subscription');

        $query = $dbo->getQuery(true)
            ->select('s.*')
            ->from($dbo->qn($subscription->getTableName(), 's'))
            ->where($dbo->qn('s.subscriber_id') . ' = ' . $dbo->q($id), 'OR')
            ->where($dbo->qn('s.user_id') . ' = ' . $dbo->q($id));

        $results = $dbo->setQuery($query)
            ->loadObjectList('id', get_class($subscription));

        return $results;
    }

    public function findUserSubscriptionsToUsers($userId, array $users = array())
    {
        if (!$users) {
            return array();
        }

        $subscription = WallFactoryTable::getInstance('Subscription');

        $dbo = $this->getDbo();
        $query = $dbo->getQuery(true)
            ->select($dbo->qn('s.user_id'))
            ->from($dbo->qn($subscription->getTableName(), 's'))
            ->where($dbo->qn('s.user_id') . ' IN (' . implode(',', $dbo->q(array_unique($users))) . ')')
            ->where($dbo->qn('s.subscriber_id') . ' = ' . $dbo->q($userId));

        $results = $dbo->setQuery($query)
            ->loadAssocList('user_id');

        return $results;
    }
}
