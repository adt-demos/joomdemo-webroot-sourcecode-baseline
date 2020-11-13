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
 * Adapter to provide information from Vimeo.
 * Required when Vimeo returns a 403 status code.
 */
class Vimeo extends Webpage implements AdapterInterface
{

    /**
     * {@inheritdoc}
     */
    public static function check(Request $request)
    {
        return $request->isValid([200, 403]) && $request->match([
            'https?://*.vimeo.com*',
            'https?://vimeo.com*',
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function run()
    {
        if ($this->request->getHttpCode() === 403) {
            $this->addProvider('oembed', new Providers\OEmbed());

         return;
        }

        parent::run();
    }

}
