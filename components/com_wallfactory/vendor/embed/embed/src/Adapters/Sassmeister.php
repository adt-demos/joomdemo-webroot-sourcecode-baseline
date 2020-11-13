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

/**
 * Adapter to generate embed code from SassMeister.
 */
class Sassmeister extends Webpage implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public static function check(Request $request)
    {
        return $request->isValid() && $request->match([
            'http://sassmeister.com/gist/*',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        $this->width = null;
        $this->height = 480;
        $id = $this->request->getDirectoryPosition(1);

        return "<p class=\"sassmeister\" data-gist-id=\"{$id}\" data-height=\"480\" data-theme=\"tomorrow\">".
               "<a href=\"http://sassmeister.com/gist/{$id}\">Play with this gist on SassMeister.</a>".
               '</p>'.
               '<script src="http://cdn.sassmeister.com/js/embed.js" async></script>';
    }
}
