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

class TableBuilder
{
    private $dbo;
    private $nameBuilder;

    public function __construct(TableNameBuilder $nameBuilder, $dbo = null)
    {
        $this->nameBuilder = $nameBuilder;
        $this->dbo = $dbo;

        if (null === $dbo) {
            $this->dbo = \JFactory::getDbo();
        }
    }

    public function build($type)
    {
        $class = 'WallFactoryTable' . ucfirst($type);
        $name = $this->nameBuilder->build($type);

        return new $class($this->dbo, $name);
    }
}
