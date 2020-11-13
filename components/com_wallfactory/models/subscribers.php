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

class WallFactoryFrontendModelSubscribers extends JModelLegacy
{
    public function findAll($userId)
    {
        $dbo = $this->getDbo();
        $subscription = WallFactoryTable::getInstance('Subscription');
        $profile = WallFactoryTable::getInstance('Profile');

        $query = $dbo->getQuery(true)
            ->select('s.user_id, s.created_at, s.subscriber_id')
            ->from($dbo->qn($subscription->getTableName(), 's'))
            ->where($dbo->qn('s.user_id') . ' = ' . $dbo->q($userId))
            ->order($dbo->qn('s.created_at') . ' DESC');

        $query->select('p.name, p.avatar_source, p.thumbnail')
            ->leftJoin($dbo->qn($profile->getTableName(), 'p') . ' ON p.user_id = s.subscriber_id');

        $results = $dbo->setQuery($query)
            ->loadObjectList();

        return $results;
    }
}
