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

class WallFactoryViewList extends WallFactoryBackendView
{
    public $filterForm;
    public $activeFilters;
    protected $items;
    protected $state;
    protected $pagination;
    protected $listDirn;
    protected $listOrder;
    protected $saveOrder;

    public function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        $this->listOrder = $this->state->get('list.ordering');
        $this->listDirn = $this->state->get('list.direction');
        $this->saveOrder = $this->listOrder == 'ordering';

        $this->addTemplatePath(__DIR__ . '/tmpl');
        $this->setLayout('list');

        return parent::display($tpl);
    }

    protected function prepareDocument()
    {
        parent::prepareDocument();

        $singular = $this->inflector->toSingular($this->getName());

        JToolBarHelper::addNew($singular . '.add');
        JToolBarHelper::editList($singular . '.edit');

        JToolBarHelper::publishList($this->getName() . '.publish');
        JToolBarHelper::unpublishList($this->getName() . '.unpublish');

        JToolBarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', $this->getName() . '.delete');
    }

    protected function getNameSingular()
    {
        return $this->inflector->toSingular($this->getName());
    }
}
