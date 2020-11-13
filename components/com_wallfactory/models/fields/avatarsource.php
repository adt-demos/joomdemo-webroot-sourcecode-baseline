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

class JFormFieldAvatarSource extends JFormFieldList
{
    protected function getOptions()
    {
        $options = parent::getOptions();

        $configuration = JComponentHelper::getParams('com_wallfactory');

        if ($configuration->get('integrations.gravatar.profile', 0)) {
            $options[] = array(
                'value' => 'gravatar',
                'text'  => 'Gravatar',
            );
        }

        $cb = \ThePhpFactory\Wall\Integration\CommunityBuilder\CommunityBuilder::getInstance($configuration);

        if ($cb->isAvatarIntegrationEnabled()) {
            $options[] = array(
                'value' => 'community_builder',
                'text'  => 'Community Builder',
            );
        }

        return $options;
    }
}
