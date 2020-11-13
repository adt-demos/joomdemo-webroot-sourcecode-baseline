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

class WallFactoryBackendModelNotifications extends WallFactoryModelList
{
    protected $ordering = 'subject';
    protected $direction = 'asc';

    public function __construct(array $config)
    {
        $config['filter_fields'] = array(
            'type_status', 'published', 'type', 'language',
        );

        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('n.*')
            ->from($dbo->qn($this->getTableName('Notification'), 'n'));

        $query->select('l.title AS language_title, l.image AS language_image')
            ->leftJoin($dbo->qn('#__languages', 'l') . ' ON l.lang_code = n.language');

        $this->filterQuery($query);
        $this->orderQuery($query);

//        echo $query->dump();

        return $query;
    }

    private function filterQuery(JDatabaseQuery $query)
    {
        $this->filterSearch($query, array('n.subject', 'n.body'));
        $this->filterNumeric($query, 'n.published');
        $this->filterString($query, 'n.language');
        $this->filterString($query, 'n.type');

        $this->filterTypeStatus($query);
    }

    private function filterTypeStatus(JDatabaseQuery $query)
    {
        if (!is_numeric($value = $this->getState('filter.type_status'))) {
            return false;
        }

        $notifications = WallFactoryNotification::getNotifications();
        $configuration = JComponentHelper::getParams('com_wallfactory');
        $types = array();

        foreach ($notifications as $notification) {
            if ((int)$value === (int)$configuration->get('notifications.' . $notification['type'] . '.enabled', 1)) {
                $types[] = $notification['type'];
            }
        }

        if (!$types) {
            return false;
        }

        $query->where($query->qn('n.type') . ' IN (' . implode(', ', $query->q($types)) . ')');
    }
}
