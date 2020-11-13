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

use Embed\Adapters\AdapterInterface;
use Embed\Adapters\Webpage;
use Embed\Request;

class VimeoAdapter extends Webpage implements AdapterInterface, VideoAdapterInterface
{
    private $parameters;

    public static function check(Request $request)
    {
        return $request->isValid() && $request->match(array(
                'https?://*.vimeo.*',
                'https?://vimeo.*',
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

        $search = array('/width="(\d+)"/', '/height="(\d+)"/');
        $replace = array('width="' . $this->parameters['width'] . '"', 'height="' . $this->parameters['height'] . '"');

        $code = preg_replace($search, $replace, $code);

        return $code;
    }
}
