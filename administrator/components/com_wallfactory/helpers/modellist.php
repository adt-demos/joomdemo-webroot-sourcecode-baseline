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

abstract class WallFactoryModelList extends JModelList
{
    protected $ordering;
    protected $direction;

    public function __construct($config = array())
    {
        $this->initialise();

        if (!isset($config['filter_fields'])) {
            $config['filter_fields'] = array();
        }

        $this->prepareFilter();

        parent::__construct($config);
    }

    private function initialise()
    {
        preg_match('/(.*)BackendModel(.*)/', get_class($this), $matches);
        $this->option = strtolower('com_' . $matches[1]);

        JForm::addFormPath(__DIR__ . '/../models/forms');
        JTable::addIncludePath(__DIR__ . '/../tables');
    }

    private function prepareFilter()
    {
        $input = JFactory::getApplication()->input;
        $session = JFactory::getSession();
        $context = $this->option . '.' . $this->getName() . '.filter';

        if ($input->get->getInt('reset', 0)) {
            $session->get('registry')->set($context, array());
        }

        $filter = $input->get->get('filter', array(), 'array');

        if ($filter) {
            $stateFilter = $session->get('registry')->get($context, array());
            $input->set('filter', $filter + $stateFilter);
        }
    }

    protected function orderQuery(JDatabaseQuery $query)
    {
        $orderCol = $this->state->get('list.ordering', $this->ordering);
        $orderDirn = $this->state->get('list.direction', $this->direction);

        $query->order($query->escape($orderCol . ' ' . $orderDirn));
    }

    protected function getTableName($table = '', $prefix = '')
    {
        return $this->getTable($table, $prefix)->getTableName();
    }

    public function getTable($name = '', $prefix = '', $options = array())
    {
        preg_match('/(.*)BackendModel(.*)/', get_class($this), $matches);

        if ('' === $name) {
            $inflector = \Joomla\String\Inflector::getInstance();
            $name = $inflector->toSingular($matches[2]);
        }

        if ('' === $prefix) {
            $prefix = $matches[1] . 'Table';
        }

        return WallFactoryTable::getInstance($name, $prefix);
    }

    protected function getFilterFields()
    {
        $form = JForm::getInstance($this->getName() . '.filter', 'filter_' . $this->getName());

        /** @var JFormField $field */
        $fields = array();
        foreach ($form->getGroup('filter') as $field) {
            $fields[] = $field->getAttribute('name');
        }

        return $fields;
    }

    protected function getTableFields()
    {
        $table = $this->getTable();

        return array_keys($table->getFields());
    }

    protected function filterNumeric(JDatabaseQuery $query, $field)
    {
        list($alias, $field) = explode('.', $field);

        if (is_numeric($value = $this->getState('filter.' . $field))) {
            $query->where($query->qn($alias . '.' . $field) . ' = ' . $query->q((int)$value));
        }
    }

    protected function filterString(JDatabaseQuery $query, $field)
    {
        list($alias, $field) = explode('.', $field);

        if ('' !== $value = trim((string)$this->getState('filter.' . $field, ''))) {
            $query->where($query->qn($alias . '.' . $field) . ' = ' . $query->q($value));
        }
    }

    protected function filterSearch(JDatabaseQuery $query, $fields)
    {
        if ('' !== $value = trim((string)$this->getState('filter.search'))) {
            if (!is_array($fields)) {
                $fields = array($fields);
            }

            $conditions = array();

            foreach ($fields as $field) {
                list($alias, $field) = explode('.', $field);

                if (0 === strpos($value, '#')) {
                    $id = substr($value, 1);
                    $conditions[] = $query->qn($alias . '.id') . ' = ' . $query->q($id);
                }
                else {
                    $conditions[] = $query->qn($alias . '.' . $field) . ' LIKE ' . $query->q('%' . $value . '%');
                }
            }

            $query->where('(' . implode(' OR ', $conditions) . ')');
        }
    }
}
