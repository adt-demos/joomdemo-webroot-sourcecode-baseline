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

use Embed\Request;
use Embed\Providers;

/**
 * Adapter to provide all information from any webpage.
 */
class Webpage extends Adapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public static function check(Request $request)
    {
        return $request->isValid();
    }

    /**
     * {@inheritdoc}
     */
    protected function run()
    {
        $this->addProvider('oembed', new Providers\OEmbed());
        $this->addProvider('opengraph', new Providers\OpenGraph());
        $this->addProvider('twittercards', new Providers\TwitterCards());
        $this->addProvider('dcterms', new Providers\Dcterms());
        $this->addProvider('sailthru', new Providers\Sailthru());
        $this->addProvider('html', new Providers\Html());
    }
}
