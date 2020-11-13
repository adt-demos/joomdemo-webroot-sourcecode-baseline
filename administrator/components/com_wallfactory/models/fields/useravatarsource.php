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

use Joomla\CMS\Component\ComponentHelper;
use ThePhpFactory\Wall\Integration\CommunityBuilder\CommunityBuilder;

class JFormFieldUserAvatarSource extends JFormFieldList
{
    protected function getOptions()
    {
        $configuration = ComponentHelper::getParams('com_wallfactory');
        $cb = CommunityBuilder::getInstance($configuration);
        $options = parent::getOptions();

        // None
        $options[] = [
            'value' => 'none',
            'text' => 'None',
        ];

        // My Avatar
        $options[] = [
            'value' => 'thumbnail',
            'text' => 'User uploaded avatar',
        ];

        // Gravatar
        if ($configuration->get('integrations.gravatar.profile', 0)) {
            $options[] = [
                'value' => 'gravatar',
                'text' => 'Gravatar',
            ];
        }

        // Community Builder
        if ($cb->isAvatarIntegrationEnabled()) {
            $options[] = [
                'value' => 'community_builder',
                'text' => 'Communnity Builder avatar',
            ];
        }

        return $options;
    }
}
