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

// Configure error reporting to none.
use Joomla\CMS\Factory;

error_reporting(0);
ini_set('display_errors', 0);

foreach (array('64M', '128M', '256M') as $memory) {
    ini_set('memory_limit', $memory);
}

foreach (array(60, 120, 180) as $time) {
    ini_set('max_execution_time', $time);
}

define('_JEXEC', 1);
defined('_JEXEC') or die;
const JDEBUG = false;

// Load system defines
if (file_exists(__DIR__ . '/../../defines.php')) {
    require_once __DIR__ . '/../../defines.php';
}

if (!defined('_JDEFINES')) {
    define('JPATH_BASE', __DIR__ . '/../../');
    require_once JPATH_BASE . '/includes/defines.php';
}

// Get the framework.
require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/cms.php';

// Exceptions handler.
set_exception_handler(function (Exception $e) {
    echo '<h1>An error occurred!</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
});

// Initialise variables.
$params = JComponentHelper::getParams('com_wallfactory');
$input = new JInput();
$password = $input->getString('password');

// Check if password was configured.
if ('' === $params->get('cronjob.password', '')) {
    throw new Exception('Cron Job password not set!');
}

// Check if passwords match.
if ($password !== $params->get('cronjob.password')) {
    throw new Exception('Wrong credentials!');
}

Factory::getApplication('site');
require_once JPATH_SITE . '/components/com_wallfactory/vendor/autoload.php';
JLoader::discover('WallFactory', JPATH_ADMINISTRATOR . '/components/com_wallfactory/helpers');

WallFactoryEvent::registerSubscribers();
WallFactoryLogger::registerLogger('cron', true);

$start = microtime(true);
WallFactoryLogger::log('START Cron Job', 'cron', false);

$actions = Factory::getApplication()->triggerEvent('onCronJob', array(
    'com_wallfactory',
));

$duration = microtime(true) - $start;
WallFactoryLogger::log(sprintf('STOP Cron Job (%.2fs)', $duration), 'cron', false);

echo 'All done!';
echo '<ul>';
foreach ($actions as $action) {
    echo '<li>' . $action . '</li>';
}
echo '</ul>';
