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

namespace ThePhpFactory\Wall\Integration\CommunityBuilder;

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

class CommunityBuilder
{
    private static $instance = null;
    private $configuration;
    private $avatarIntegrationEnabled = null;
    private $avatars = array();

    public function __construct(Registry $configuration)
    {
        $this->configuration = $configuration;
    }

    public static function getInstance(Registry $configuration)
    {
        if (null === self::$instance) {
            self::$instance = new self($configuration);
        }

        return self::$instance;
    }

    public function isAvatarIntegrationEnabled()
    {
        if (null === $this->avatarIntegrationEnabled) {
            $this->avatarIntegrationEnabled = false;

            if ($this->configuration->get('integrations.community_builder.avatar', 0)) {
                $extension = \JTable::getInstance('Extension');
                $result = $extension->find(array(
                    'type'    => 'component',
                    'element' => 'com_comprofiler',
                    'enabled' => 1,
                ));

                if ($result) {
                    $this->avatarIntegrationEnabled = true;
                }
            }
        }

        return $this->avatarIntegrationEnabled;
    }

    public function getAvatarIntegrationSource($userId)
    {
        if (!isset($this->avatars[$userId])) {
            $this->avatars[$userId] = '';

            $dbo = \JFactory::getDbo();
            $query = $dbo->getQuery(true)
                ->select($dbo->qn('avatar'))
                ->from($dbo->qn('#__comprofiler'))
                ->where($dbo->qn('id') . ' = ' . $dbo->q($userId))
                ->where($dbo->qn('avatarapproved') . ' = ' . $dbo->q(1));

            $result = $dbo->setQuery($query)
                ->loadResult();

            if ($result) {
                $this->avatars[$userId] = Uri::root() . 'images/comprofiler/' . $result;
            }
        }

        return $this->avatars[$userId];
    }
}
