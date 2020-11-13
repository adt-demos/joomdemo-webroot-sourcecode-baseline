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

$option = 'com_wallfactory';
$component = 'WallFactory';

JLoader::register($component . 'Helper', JPATH_ADMINISTRATOR . '/components/' . $option . '/helpers/' . strtolower($component) . '.php');
JLoader::discover($component, JPATH_ADMINISTRATOR . '/components/' . $option . '/helpers');
JLoader::discover('JHtml' . $component, JPATH_ADMINISTRATOR . '/components/' . $option . '/helpers/html');
JLoader::register('JHtml' . $component, JPATH_ADMINISTRATOR . '/components/' . $option . '/helpers/html/' . strtolower($component) . '.php');

JLoader::discover('WallFactoryFrontendModel', JPATH_SITE . '/components/com_wallfactory/models');
JLoader::discover('WallFactoryNotification', JPATH_ADMINISTRATOR . '/components/com_wallfactory/helpers/notifications');
JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_wallfactory/tables');
