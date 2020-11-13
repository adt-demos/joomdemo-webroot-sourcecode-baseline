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

abstract class WallFactoryControllerAdmin extends JControllerAdmin
{
    protected $option;
    protected $text_prefix;

    public function __construct(array $config)
    {
        parent::__construct($config);

        preg_match('/(.*)BackendController(.*)/', get_class($this), $matches);

        $this->option = strtolower('com_' . $matches[1]);
        $this->text_prefix = strtoupper($this->option);
    }

    public function getModel($name = '', $prefix = '', $config = array())
    {
        preg_match('/(.*)BackendController(.*)/', get_class($this), $matches);

        if ('' === $name) {
            $inflector = \Joomla\String\Inflector::getInstance();
            $name = $inflector->toSingular($matches[2]);
        }

        if ('' === $prefix) {
            $prefix = $matches[1] . 'BackendModel';
        }

        return parent::getModel($name, $prefix, $config);
    }
}
