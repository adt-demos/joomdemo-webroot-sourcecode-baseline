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

require_once JPATH_SITE . '/components/com_wallfactory/vendor/autoload.php';
require_once JPATH_SITE . '/components/com_wallfactory/loader.php';

WallFactoryHelper::setSqlMode();

WallFactoryEvent::registerSubscribers();
WallFactoryLogger::registerLogger(array('notification', 'entity'));

$input = JFactory::getApplication()->input;

$controller = JControllerLegacy::getInstance('WallFactoryBackend');
$controller->execute($input->getCmd('task'));
$controller->redirect();

WallFactoryHelper::resetSqlMode();

WallFactoryUpgrade::check();
