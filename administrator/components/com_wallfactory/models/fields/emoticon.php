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

defined('_JEXEC') or die;

class JFormFieldEmoticon extends JFormField
{
    protected $layout = 'helpers.layouts.fields.emoticon';

    protected function getLayoutPaths()
    {
        return array(
            __DIR__ . '/../../',
            JPATH_SITE . '/layouts',
        );
    }
}
