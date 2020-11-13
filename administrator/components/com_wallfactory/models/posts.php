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

class WallFactoryBackendModelPosts extends WallFactoryModelList
{
    protected $ordering = 'created_at';
    protected $direction = 'desc';

    public function __construct(array $config)
    {
        $config['filter_fields'] = array(
            'published', 'created_at', 'id',
            'user_id', 'to_user_id',
        );

        parent::__construct($config);
    }

    public function getLatest($limit = 5)
    {
        $this->setState('list.limit', $limit);

        return $this->getItems();
    }

    public function getTotal()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('COUNT(1)')
            ->from($dbo->qn($this->getTableName('Post'), 'p'));

        $this->filterQuery($query);

        $total = $dbo->setQuery($query)
            ->loadResult();

        return (int)$total;
    }

    private function filterQuery(JDatabaseQuery $query)
    {
        $this->filterSearch($query, array('p.content'));
        $this->filterNumeric($query, 'p.published');
        $this->filterNumeric($query, 'p.user_id');
        $this->filterNumeric($query, 'p.to_user_id');
    }

    public function getSubQueryForCount($alias = 'p')
    {
        $dbo = $this->getDbo();

        $query = $dbo->getQuery(true)
            ->select('COUNT(1)')
            ->from($dbo->qn($this->getTableName('Post'), 'ps'))
            ->where($dbo->qn('ps.user_id') . ' = ' . $dbo->qn($alias . '.user_id'));

        return $query;
    }

    public function getSubQueryForLastCreatedAt($alias = 'p')
    {
        $dbo = $this->getDbo();

        $query = $dbo->getQuery(true)
            ->select('MAX(psc.created_at)')
            ->from($dbo->qn($this->getTableName('Post'), 'psc'))
            ->where($dbo->qn('psc.user_id') . ' = ' . $dbo->qn($alias . '.user_id'));

        return $query;
    }

    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);

        $filterUser = $this->getState('filter.user_id');

        if (!is_numeric($filterUser) || 0 === (int)$filterUser) {
            $form->removeField('user_id', 'filter');
        }

        $filterToUser = $this->getState('filter.to_user_id');

        if (!is_numeric($filterToUser) || 0 === (int)$filterToUser) {
            $form->removeField('to_user_id', 'filter');
        }
    }

    protected function getListQuery()
    {
        /** @var WallFactoryBackendModelComments $repoComments */
        $repoComments = JModelLegacy::getInstance('Comments', 'WallFactoryBackendModel');

        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('p.*')
            ->from($dbo->qn($this->getTableName('Post'), 'p'));

        $query->select('IF (p.user_id, pf.name, p.author_name) AS name')
            ->leftJoin($dbo->qn($this->getTableName('Profile'), 'pf') . ' ON pf.user_id = p.user_id');

        $query->select('to.name AS to_name')
            ->leftJoin($dbo->qn($this->getTableName('Profile'), 'to') . ' ON to.user_id = p.to_user_id');

        $query->select('(' . $repoComments->getSubQueryForCount() . ') AS ' . $dbo->qn('comments'));

        $query->select('u.username, u.id AS user_id')
            ->leftJoin($dbo->qn($this->getTableName('User', 'JTable'), 'u') . ' ON u.id = p.user_id');

        $this->filterQuery($query);
        $this->orderQuery($query);

        return $query;
    }
}
