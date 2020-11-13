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

class JFormRuleLogged extends JFormRule
{
    public function test(SimpleXMLElement $element, $value, $group = null, \Joomla\Registry\Registry $input = null, JForm $form = null)
    {
        if (0 === (int)$value) {
            throw new Exception(WallFactoryText::_('rule_logged_error'));
        }

        return true;
    }
}
