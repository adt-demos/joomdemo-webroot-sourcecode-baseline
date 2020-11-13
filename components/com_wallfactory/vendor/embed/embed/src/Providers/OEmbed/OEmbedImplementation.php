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

/**
 * Abstract class extended by all oembed classes.
 *
 * Provides the endPoint, pattern and params of the well known oembed implementations
 */
abstract class OEmbedImplementation
{
    /**
     * @author Oliver Lillie
     *
     * @return string
     */
    public static function getEndPoint(Url $url)
    {
        return '';
    }

    /**
     * @author Oliver Lillie
     *
     * @return array
     */
    public static function getPatterns()
    {
        return [];
    }

    /**
     * @author Oliver Lillie
     *
     * @return array
     */
    public static function getParams(Url $url)
    {
        return [];
    }

    /**
     * @author Dave Ross
     *
     * @return bool
     */
    public static function embedInDomIsBroken()
    {
        return false;
    }
}
