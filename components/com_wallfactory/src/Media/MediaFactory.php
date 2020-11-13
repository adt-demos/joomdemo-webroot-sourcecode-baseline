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

namespace ThePhpFactory\Wall\Media;

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class MediaFactory
{
    public static function build($type)
    {
        $class = '\\ThePhpFactory\\Wall\\Media\\' . ucfirst($type) . '\\' . ucfirst($type) . 'Media';

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Media type %s does not exist!', $type));
        }

        if (!is_subclass_of($class, '\\ThePhpFactory\\Wall\\Media\\MediaInterface')) {
            throw new \Exception(sprintf('Type %s is not a media!', $type));
        }

        $params = \JComponentHelper::getParams('com_wallfactory');
        $options = new Registry($params->get('posting.' . $type));

        if (false === (boolean)$options->get('enabled', 0)) {
            throw new \Exception(sprintf('Media type %s is not enabled!', $type));
        }

        $class = new $class($options);

        return $class;
    }
}
