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

class JFormFieldCronJobUrl extends JFormFieldText
{
    protected function getInput()
    {
        $html = array();

        $password = $this->form->getValue('cronjob.password');
        $url = JUri::root() . 'components/com_wallfactory/cronjob.php?password=' . urlencode($password);

        $html[] = '<a href="' . $url . '" target="_blank">' . $url . '</a>';

        return implode($html);
    }
}
