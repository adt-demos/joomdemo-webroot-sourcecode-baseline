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

namespace ThePhpFactory\Wall\Controller;

defined('_JEXEC') or die;

class EmoticonController extends BaseController
{
    public function index()
    {
        if (!$this->configuration->get('posting.emoticons.enabled', 1)) {
            return null;
        }

        $emoticonRepository = new \WallFactoryFrontendModelEmoticon();

        $emoticons = $emoticonRepository->findAll();

        return $this->render('emoticon.index', array(
            'emoticons' => $emoticons,
        ));
    }
}
