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

class WallFactoryBackendModelReports extends WallFactoryModelList
{
    protected $ordering = 'created_at';
    protected $direction = 'desc';

    public function __construct(array $config)
    {
        $config['filter_fields'] = array(
            'resolved', 'created_at', 'id',
            'user_id', 'resource_user_id', 'resource_id',
            'resource_type',
        );

        parent::__construct($config);
    }

    public function countUnresolvedReports()
    {
        $this->setState('filter.resolved', 0);

        return $this->getTotal();
    }

    public function getTotal()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('COUNT(1)')
            ->from($dbo->qn($this->getTableName('Report'), 'r'));

        $this->filterQuery($query);

        $total = $dbo->setQuery($query)
            ->loadResult();

        return (int)$total;
    }

    private function filterQuery(JDatabaseQuery $query)
    {
        $this->filterSearch($query, array('r.comment'));
        $this->filterString($query, 'r.resource_type');
        $this->filterNumeric($query, 'r.resolved');
        $this->filterNumeric($query, 'r.resource_id');
        $this->filterNumeric($query, 'r.user_id');
        $this->filterNumeric($query, 'r.resource_user_id');
    }

    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);

        if (!is_numeric($this->getState('filter.user_id')) || 0 === (int)$this->getState('filter.user_id')) {
            $form->removeField('user_id', 'filter');
        }
    }

    protected function getListQuery()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('r.*')
            ->from($dbo->qn($this->getTableName('Report'), 'r'));

        $query->select('reported.username AS resource_username')
            ->leftJoin($dbo->qn($this->getTableName('User', 'JTable'), 'reported') . ' ON reported.id = r.resource_user_id');

        $query->select('reported_profile.name AS reported_name')
            ->leftJoin($dbo->qn($this->getTableName('Profile'), 'reported_profile') . ' ON reported_profile.user_id = r.resource_user_id');

        $query->select('reporting.username AS reporting_username')
            ->leftJoin($dbo->qn($this->getTableName('User', 'JTable'), 'reporting') . ' ON reporting.id = r.user_id');

        $query->select('reporting_profile.name AS reporting_name')
            ->leftJoin($dbo->qn($this->getTableName('Profile'), 'reporting_profile') . ' ON reporting_profile.user_id = r.user_id');

        $this->filterQuery($query);
        $this->orderQuery($query);

//        echo $query->dump();

        return $query;
    }
}
