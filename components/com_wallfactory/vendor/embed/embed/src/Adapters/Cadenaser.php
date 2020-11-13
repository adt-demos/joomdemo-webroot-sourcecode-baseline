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

namespace Embed\Adapters;

defined('_JEXEC') or die;

use Embed\Utils;
use Embed\Request;

/**
 * Adapter to get the embed code from play.cadenaser.com.
 */
class Cadenaser extends Webpage implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public static function check(Request $request)
    {
        return $request->isValid() && $request->match([
            'https?://play.cadenaser.com/audio/*',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        $url = $this->request->createUrl();
        $url = $url->withPath('/widget/'.$url->getPath());

        return Utils::iframe($url->getUrl(), $this->width, $this->height);
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return 620;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return 100;
    }
}
