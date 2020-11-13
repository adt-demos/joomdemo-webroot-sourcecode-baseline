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

class Vimeo extends OEmbedImplementation
{

    /**
     * @inheritDoc
     */
    public static function getEndPoint(Url $url)
    {
        return 'https://vimeo.com/api/oembed.json';
    }

    /**
     * @inheritDoc
     */
    public static function getPatterns()
    {
        return [
            'https?://*.vimeo.com*',
            'https?://vimeo.com*',
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getParams(Url $url)
    {
        return [
            'url' => $url->withScheme('http')->getUrl(),
        ];
    }
}
