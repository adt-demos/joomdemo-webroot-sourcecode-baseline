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

class WallFactoryTable extends JTable
{
    private static $builder = null;
    protected $primaryKey = 'id';
    private $extraProperties = array();

    public function __construct(JDatabaseDriver $db = null, $name = null)
    {
        if (null === $db) {
            $db = JFactory::getDbo();
        }

        if (null === $name) {
            $class = strtolower(str_replace(__CLASS__, '', get_class($this)));

            $inflector = \Joomla\String\Inflector::getInstance();
            $inflector->addWord('media', 'media');

            $plural = $inflector->toPlural($class);

            $prefix = strtolower(str_replace('Table', '', __CLASS__));

            $name = '#__com_' . $prefix . '_' . $plural;
        }

        parent::__construct($name, $this->primaryKey, $db);
    }

    public static function getInstance($type = null, $prefix = '', $config = array())
    {
        if ('JTable' === $prefix) {
            return JTable::getInstance($type, $prefix);
        }

        if (null === self::$builder) {
            \JLoader::discover('WallFactoryTable', JPATH_ADMINISTRATOR . '/components/com_wallfactory/tables');

            $nameBuilder = new \ThePhpFactory\Wall\TableNameBuilder('#__com_wallfactory_');
            self::$builder = new ThePhpFactory\Wall\TableBuilder($nameBuilder);
        }

        return self::$builder->build($type, $prefix, $config);
    }

    public static function setBuilder($builder)
    {
        self::$builder = $builder;
    }

    public function check()
    {
        if (!parent::check()) {
            return false;
        }

        if ($this->hasEmptyDate('created_at')) {
            $this->created_at = JFactory::getDate()->toSql();
        }

        if ($this->hasEmptyDate('updated_at')) {
            $this->updated_at = JFactory::getDate()->toSql();
        }

//        if ($this->hasEmptyUser('user_id')) {
//            $this->user_id = JFactory::getUser()->id;
//        }

        $rClass = new ReflectionClass($this);
        $validProperties = array();

        foreach ($rClass->getProperties() as $property) {
            if (!$property->isPublic() || 0 === strpos($property->getName(), '_')) {
                continue;
            }

            $validProperties[] = $property->getName();
        }

        foreach ($this->getProperties() as $pName => $pValue) {
            if (!in_array($pName, $validProperties)) {
                $this->extraProperties[$pName] = $pValue;
                unset($this->$pName);
            }
        }

        return true;
    }

    private function hasEmptyDate($name)
    {
        if (!$this->hasProperty($name)) {
            return false;
        }

        return in_array($this->$name, array(null, '', $this->getDbo()->getNullDate()), true);
    }

    private function hasProperty($name)
    {
        return property_exists($this, $name);
    }

    public function store($updateNulls = false)
    {
        if (!parent::store($updateNulls)) {
            return false;
        }

        foreach ($this->extraProperties as $name => $value) {
            $this->$name = $value;
        }

        return true;
    }

    public function delete($pk = null)
    {
        if (!parent::delete($pk)) {
            return false;
        }

        WallFactoryLogger::log(
            sprintf('REMOVED %s #%d', str_replace('WallFactoryTable', '', get_class($this)), $this->{$this->primaryKey}),
            'entity'
        );

        return true;
    }

    public function __debugInfo()
    {
        return $this->getProperties();
    }

    protected function raise($event, array $params = array())
    {
        $args = array_merge(array('com_wallfactory'), $params);

        \Joomla\CMS\Factory::getApplication()->triggerEvent($event, $args);
    }

    private function hasEmptyUser($name = 'user_id')
    {
        if (!$this->hasProperty($name)) {
            return false;
        }

        return 0 === (int)$this->$name;
    }
}
