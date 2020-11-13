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

namespace Embed\Sources;

defined('_JEXEC') or die;

use Embed\Request;

/**
 * Interface used by all sources.
 */
interface SourceInterface
{
    /**
     * Checks whether the url is a source url.
     *
     * @param Request $request
     *
     * @return bool
     */
    public static function check(Request $request);

    /**
     * Constructor of the source.
     *
     * @param Request $request
     */
    public function __construct(Request $request);

    /**
     * Returns whether the source is a valid url or not.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Returns the source url.
     *
     * @return string
     */
    public function getSourceUrl();

    /**
     * Returns the provider url if it's available.
     *
     * @return null|string
     */
    public function getProviderUrl();

    /**
     * Returns all items (urls) found in this source.
     *
     * @return array
     */
    public function getItems();
}
