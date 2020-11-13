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

class WallFactoryBackendModelBookmarks extends WallFactoryModelList
{
    protected $ordering = 'ordering';
    protected $direction = 'asc';

    public function __construct(array $config)
    {
        $config['filter_fields'] = array(
            'published', 'title', 'id',
        );

        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $dbo = $this->getDbo();
        $query = parent::getListQuery();

        $query->select('b.*')
            ->from($dbo->qn($this->getTableName('Bookmark'), 'b'));

        $this->filterQuery($query);
        $this->orderQuery($query);

//        echo $query->dump();

        return $query;
    }

    private function filterQuery(JDatabaseQuery $query)
    {
        $this->filterSearch($query, 'b.title');
        $this->filterNumeric($query, 'b.published');
    }
}
