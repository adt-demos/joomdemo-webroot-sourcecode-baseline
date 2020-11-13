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

use Embed\GetTrait;

/**
 * Base Source extended by all sources
 * Provide default functionalities.
 *
 * @property null|string $providerUrl
 * @property string      $sourceUrl
 * @property array       $items
 */
abstract class Source
{
    use GetTrait;

    public $request;
}
