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

namespace Embed\RequestResolvers;

defined('_JEXEC') or die;

/**
 * Interface used by all request resolver classes.
 */
interface RequestResolverInterface
{
    /**
     * Constructor. Sets the url.
     *
     * @param string $url    The url value
     * @param array  $config The resolver configuration
     */
    public function __construct($url, array $config);

    /**
     * Get the http code of the url, for example: 200.
     *
     * @return int The http code
     */
    public function getHttpCode();

    /**
     * Get the content-type of the url, for example: text/html.
     *
     * @return string The content-type header or null
     */
    public function getMimeType();

    /**
     * Returns the connection error if exists.
     *
     * @return string|null
     */
    public function getError();

    /**
     * Get the content of the url.
     *
     * @return string The content or false
     */
    public function getContent();

    /**
     * Returns the final url (after all possible redirects).
     *
     * @return string The final url
     */
    public function getUrl();

    /**
     * Returns the http request info (for debug purposes).
     *
     * @return array
     */
    public function getRequestInfo();

    /**
     * Returns the http headers.
     *
     * @return array
     */
    public function getHeaders();
}
