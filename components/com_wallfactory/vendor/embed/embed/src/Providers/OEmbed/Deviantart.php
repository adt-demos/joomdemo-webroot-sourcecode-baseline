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

namespace Embed\Providers\OEmbed;

defined('_JEXEC') or die;

use Embed\Url;

class Deviantart extends OEmbedImplementation
{
    /**
     * {@inheritdoc}
     */
    public static function getEndPoint(Url $url)
    {
        return 'http://backend.deviantart.com/oembed';
    }

    /**
     * {@inheritdoc}
     */
    public static function getPatterns()
    {
        return ['http://*.deviantart.com/art/*', 'http://www.deviantart.com/#/d*'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getParams(Url $url)
    {
        return [
            'for' => 'embed',
        ];
    }
}
