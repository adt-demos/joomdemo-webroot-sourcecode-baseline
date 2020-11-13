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

namespace ThePhpFactory\Wall;

defined('_JEXEC') or die;

class TableNameBuilder
{
    private $prefix;

    public function __construct($prefix = null)
    {
        $this->prefix = $prefix;
    }

    public function build($type)
    {
        $class = strtolower($type);

        $inflector = \Joomla\String\Inflector::getInstance();
        $inflector->addWord('media', 'media');

        $plural = $inflector->toPlural($class);

        $name = $this->prefix . $plural;

        return $name;
    }
}
