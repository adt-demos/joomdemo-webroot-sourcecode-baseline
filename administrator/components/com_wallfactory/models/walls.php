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

class WallFactoryBackendModelWalls extends WallFactoryModelList
{
    protected $ordering = 'created_at';
    protected $direction = 'desc';

    public function __construct(array $config)
    {
        $config['filter_fields'] = array(
            'name',
            'posts',
        );

        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('w.*')
            ->from($dbo->qn($this->getTableName('Wall'), 'w'));

        $query->select('u.username, u.name')
            ->leftJoin($dbo->qn($this->getTableName('User', 'JTable'), 'u') . ' ON u.id = w.user_id');

        $query->select('COUNT(p.id) AS posts, MAX(p.created_at) AS last_post_created_at')
            ->leftJoin($dbo->qn($this->getTableName('Post'), 'p') . ' ON p.wall_id = w.id')
            ->group('w.id');

        $this->filterQuery($query);
        $this->orderQuery($query);

//    echo $query->dump();

        return $query;
    }

    private function filterQuery(JDatabaseQuery $query)
    {
        $this->filterSearch($query, array('w.title'));
        $this->filterNumeric($query, 'w.published');

        if (true === $filter = (boolean)$this->getState('filter.with_posts', false)) {
            $query->having($query->qn('posts') . ' > ' . $query->q(0));
        }
    }
}
