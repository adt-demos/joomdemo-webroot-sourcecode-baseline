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

class WallFactoryFrontendModelProfiles extends JModelLegacy
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

    public function findProfileDisplayByIds(array $ids = array())
    {
        if (!$ids) {
            return array();
        }

        $profile = WallFactoryTable::getInstance('Profile');
        $dbo = $this->getDbo();

        $query = $dbo->getQuery(true)
            ->select($dbo->qn(array('p.user_id', 'p.name', 'p.avatar_source', 'p.thumbnail')))
            ->from($dbo->qn($profile->getTableName(), 'p'))
            ->where('p.user_id IN (' . implode(',', $dbo->q($ids)) . ')');

        $results = $dbo->setQuery($query)
            ->loadAssocList('user_id');

        return $results;
    }
}
