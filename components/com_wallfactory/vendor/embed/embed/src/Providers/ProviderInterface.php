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

namespace Embed\Providers;

defined('_JEXEC') or die;

use Embed\Request;
use Embed\DataInterface;

/**
 * Interface used by all providers.
 */
interface ProviderInterface extends DataInterface
{
    /**
     * Init the provider.
     *
     * @param Request $request
     * @param array   $config
     */
    public function init(Request $request, array $config = null);

    /**
     * Run the provider.
     */
    public function run();
}
