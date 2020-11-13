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

namespace ThePhpFactory\Wall\Media\Video\Adapter;

defined('_JEXEC') or die;

use Embed\Adapters\Howcast;
use Embed\Request;

class HowcastAdapter extends Howcast implements VideoAdapterInterface
{
    private $parameters;

    public static function check(Request $request)
    {
        return $request->isValid() && $request->match(array(
                'https?://*.howcast.*',
            ));
    }

    public function setParameters(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    public function getCode()
    {
        $code = parent::getCode();

        if (!$this->parameters['height'] || !$this->parameters['width']) {
            return $code;
        }

        $search = array('/width="(\d+)px"/', '/height="(\d+)px"/');
        $replace = array('width="' . $this->parameters['width'] . 'px"', 'height="' . $this->parameters['height'] . 'px"');

        $code = preg_replace($search, $replace, $code);

        return $code;
    }
}
