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

class MetacafeAdapter extends Howcast implements VideoAdapterInterface
{
    private $parameters;

    public static function check(Request $request)
    {
        return $request->isValid() && $request->match(array(
                'https?://*.metacafe.*',
            ));
    }

    public function setParameters(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    public function getCode()
    {
        if (!preg_match('#(?<=watch/).*?(?=/)#', $this->getUrl(), $matches)) {
            return null;
        }

        $code = sprintf(
            '<iframe width="560" height="315" src="http://www.metacafe.com/embed/%d/?ap=0" frameborder="0" allowfullscreen></iframe>',
            end($matches)
        );

        if (!$this->parameters['height'] || !$this->parameters['width']) {
            return $code;
        }

        $search = array('/width="(\d+)"/', '/height="(\d+)"/');
        $replace = array('width="' . $this->parameters['width'] . '"', 'height="' . $this->parameters['height'] . '"');

        $code = preg_replace($search, $replace, $code);

        return $code;
    }
}
