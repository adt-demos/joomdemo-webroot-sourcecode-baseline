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

class WallFactoryBackendModelComments extends WallFactoryModelList
{
    protected $ordering = 'created_at';
    protected $direction = 'desc';

    public function __construct(array $config)
    {
        $config['filter_fields'] = array(
            'published', 'created_at', 'id',
            'user_id', 'post_id',
        );

        parent::__construct($config);
    }

    public function getSubQueryForCount($alias = 'p')
    {
        $dbo = $this->getDbo();

        $query = $dbo->getQuery(true)
            ->select('COUNT(1)')
            ->from($dbo->qn($this->getTableName('Comment'), 'c'))
            ->where($dbo->qn('c.post_id') . ' = ' . $dbo->qn($alias . '.id'));

        return $query;
    }

    public function getTotal()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('COUNT(1)')
            ->from($dbo->qn($this->getTableName('Comment'), 'c'));

        $this->filterQuery($query);

        $total = $dbo->setQuery($query)
            ->loadResult();

        return (int)$total;
    }

    private function filterQuery(JDatabaseQuery $query)
    {
        $this->filterSearch($query, array('c.content'));
        $this->filterNumeric($query, 'c.published');
        $this->filterNumeric($query, 'c.user_id');
        $this->filterNumeric($query, 'c.post_id');
    }

    protected function preprocessForm(JForm $form, $data, $group = 'content')
    {
        parent::preprocessForm($form, $data, $group);

        if (!is_numeric($this->getState('filter.wall_id')) || 0 === (int)$this->getState('filter.wall_id')) {
            $form->removeField('wall_id', 'filter');
        }

        if (!is_numeric($this->getState('filter.post_id')) || 0 === (int)$this->getState('filter.post_id')) {
            $form->removeField('post_id', 'filter');
        }

        if (!is_numeric($this->getState('filter.user_id'))) {
            $form->removeField('user_id', 'filter');
        }
    }

    protected function getListQuery()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('c.*')
            ->from($dbo->qn($this->getTableName('Comment'), 'c'));

        $query->select('u.username')
            ->leftJoin($dbo->qn($this->getTableName('User', 'JTable'), 'u') . ' ON u.id = c.user_id');

        $query->select('p.name')
            ->leftJoin($dbo->qn($this->getTableName('Profile'), 'p') . ' ON p.user_id = c.user_id');

        $this->filterQuery($query);
        $this->orderQuery($query);

//    echo $query->dump();

        return $query;
    }
}
