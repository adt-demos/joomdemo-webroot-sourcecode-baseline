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

class WallFactoryBackendModelSubscriptions extends JModelLegacy
{
    public function getTotal()
    {
        $dbo = $this->getDbo();
        $subscription = WallFactoryTable::getInstance('Subscription');

        $query = $dbo->getQuery(true)
            ->select('COUNT(1)')
            ->from($dbo->qn($subscription->getTableName()));

        $result = $dbo->setQuery($query)
            ->loadResult();

        return $result;
    }
}
