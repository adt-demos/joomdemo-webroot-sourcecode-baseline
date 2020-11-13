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

class WallFactoryBackendModelUsers extends WallFactoryModelList
{
    protected $ordering = 'created_at';
    protected $direction = 'desc';

    public function __construct(array $config)
    {
        $config['filter_fields'] = array(
            'created_at', 'id',
        );

        parent::__construct($config);
    }

    public function getTable($name = 'Profile', $prefix = '', $options = array())
    {
        return parent::getTable($name, $prefix, $options);
    }

    public function getTotal()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('COUNT(1)')
            ->from($dbo->qn($this->getTableName('Profile'), 'p'));

        $this->filterQuery($query);

        $total = $dbo->setQuery($query)
            ->loadResult();

        return (int)$total;
    }

    private function filterQuery(JDatabaseQuery $query)
    {
        $this->filterSearch($query, array('p.name'));

        if (1 === $this->getState('list.has_posts')) {
            $query->having($query->qn('posts') . ' > ' . $query->q(0));
        }
    }

    protected function getListQuery()
    {
        /** @var WallFactoryBackendModelPosts $repoPosts */
        $repoPosts = JModelLegacy::getInstance('Posts', 'WallFactoryBackendModel');

        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('p.*')
            ->from($dbo->qn($this->getTableName('Profile'), 'p'));

        $query->select('u.username')
            ->leftJoin($dbo->qn($this->getTableName('User', 'JTable'), 'u') . ' ON u.id = p.user_id');

        $query->select('(' . $repoPosts->getSubQueryForCount() . ') AS posts');
        $query->select('(' . $repoPosts->getSubQueryForLastCreatedAt() . ') AS last_post_at');

        $this->filterQuery($query);
        $this->orderQuery($query);

//        echo $query->dump();

        return $query;
    }
}
