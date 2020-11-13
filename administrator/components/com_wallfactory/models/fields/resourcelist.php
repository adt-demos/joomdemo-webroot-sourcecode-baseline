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

JFormHelper::loadFieldType('List');

class JFormFieldResourceList extends JFormFieldList
{
    protected function getOptions()
    {
        $options = parent::getOptions();

        jimport('joomla.filesystem.folder');
        $files = JFolder::files(__DIR__ . '/../../helpers/reports', '.php');

        foreach ($files as $file) {
            $path = pathinfo($file);

            $options[] = array(
                'value' => $path['filename'],
                'text'  => WallFactoryText::_('report_type_' . $path['filename']),
            );
        }

        return $options;
    }
}
