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

use Joomla\Registry\Registry;

class BaseController
{
    protected $input;
    protected $configuration;

    public function __construct(\JInput $input, Registry $configuration)
    {
        $this->input = $input;
        $this->configuration = $configuration;
    }

    protected function render($layout, array $parameters = array())
    {
        $version = (int)\Joomla\CMS\Version::MAJOR_VERSION;
        \Joomla\CMS\HTML\HTMLHelper::stylesheet('media/com_wallfactory/assets/common/migration' . $version . '.css');

        return \JHtmlWallFactory::renderLayout($layout, $parameters);
    }

    protected function setMessage($message, $type = 'message')
    {
        \JFactory::getApplication()->enqueueMessage($message, $type);
    }

    protected function redirect($url)
    {
        \JFactory::getApplication()->redirect($url);
    }

    protected function isXmlHttpRequest()
    {
        return 'xmlhttprequest' === strtolower($this->input->server->get('HTTP_X_REQUESTED_WITH'));
    }
}
