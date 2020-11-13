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

$dir = JPATH_SITE . '/components/com_wallfactory';

if (!file_exists($dir . '/wallfactory.php')) {
    echo 'Install the Wall Factory extension in order to use this module!';
    return false;
}

require_once $dir . '/vendor/autoload.php';
require_once $dir . '/loader.php';

WallFactoryEvent::registerSubscribers();
WallFactoryLogger::registerLogger(array('notification', 'entity'));

$configuration = JComponentHelper::getParams('com_wallfactory');
$input = new JInput(array(
    'task'  => 'module.search',
    'query' => JFactory::getApplication()->input->get('query', ''),
));

$output = WallFactoryApp::render($input, $configuration);

echo $output;
