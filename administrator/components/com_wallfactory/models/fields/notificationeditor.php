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

class JFormFieldNotificationEditor extends JFormFieldEditor
{
    protected function getInput()
    {
        $html = array();

        $type = $this->form->getValue('type');
        $tokens = $this->getTokens($type);
        $id = $this->id;

        JFactory::getDocument()->addScriptDeclaration(
            <<<JS
jQuery(document).ready(function ($) {
  $('a[data-token]').click(function (event) {
    event.preventDefault();

    jInsertEditorText($(this).data('token'), 'jform_body');
  });
});
JS
        );

        $html[] = parent::getInput();

        $html[] = '<div>';

        foreach ($tokens as $value => $label) {
            $html[] = '<div style="margin-bottom: 5px;">';
            $html[] = '<a href="#" class="btn btn-small" data-token="' . $value . '">' . $value . '</a>';
            $html[] = '&nbsp;&mdash;&nbsp;' . $label;
            $html[] = '</div>';
        }

        $html[] = '</div>';

        return implode("\n", $html);
    }

    protected function getTokens($type)
    {
        $array = array();
        $tokens = WallFactoryNotification::getTokens($type);

        foreach ($tokens as $token) {
            $array['{{ ' . $token . ' }}'] = WallFactoryText::_('notification_' . $type . '_' . $token);
        }

        return $array;
    }
}
