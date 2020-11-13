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

class WallFactoryBackendModelConfiguration extends JModelAdmin
{
    protected $option = 'com_wallfactory';

    public function save($data)
    {
        $form = $this->getForm();
        $data = WallFactoryForm::validate($form, $data);

        if (isset($data['posting']['file']['extensions'])) {
            $data['posting']['file']['extensions'] = strtolower($data['posting']['file']['extensions']);
        }

        $extension = JTable::getInstance('Extension');
        $extension->load(array(
            'element' => $this->option,
            'type'    => 'component',
        ));

        $extension->bind(array(
            'params' => $data,
        ));

        $extension->store();

        parent::cleanCache('_system', 1);
        parent::cleanCache('_system', 0);

        return true;
    }

    public function getForm($data = array(), $loadData = false)
    {
        $form = WallFactoryForm::load($this->getName());

        $notifications = WallFactoryNotification::getNotifications();

        $xml = array();

        $xml[] = '<form>';
        $xml[] = '<fieldset name="notifications">';
        $xml[] = '<fields name="notifications">';

        foreach ($notifications as $notification) {
            $label = 'COM_WALLFACTORY_NOTIFICATION_' . strtoupper($notification['type']);
            $description = 'COM_WALLFACTORY_NOTIFICATION_ENABLED_DESC';

            $xml[] = <<<XML
<fields name="{$notification['type']}">    
    <field name="enabled" type="radio" class="switcher btn-group btn-group-yesno" filter="integer" default="1" label="$label" description="$description">
        <option value="0">JDISABLED</option>
        <option value="1">JENABLED</option>
    </field>
</fields>
XML;

            if ($notification['is_group']) {
                $label = 'COM_WALLFACTORY_NOTIFICATION_RECEIVING_GROUPS_LABEL';
                $description = 'COM_WALLFACTORY_NOTIFICATION_RECEIVING_GROUPS_DESC';

                $xml[] = <<<XML
<fields name="{$notification['type']}">
    <field name="groups" type="usergrouplist" multiple="true" label="{$label}" description="{$description}" showon="enabled:1" />
</fields>
XML;
            }

            $xml[] = '<field type="spacer" hr="true" />';
        }

        $xml[] = '</fields>';
        $xml[] = '</fieldset>';
        $xml[] = '</form>';

        $form->load(implode($xml));

        $this->parseCommunityBuilderIntegration($form);

        return $form;
    }

    private function parseCommunityBuilderIntegration(JForm $form)
    {
        $extension = JTable::getInstance('Extension');
        $result = $extension->find(array(
            'type'    => 'component',
            'element' => 'com_comprofiler',
            'enabled' => 1,
        ));

        $name = 'community_builder_' . ($result ? 'enabled' : 'disabled');

        $form->loadFile(JPATH_ADMINISTRATOR . '/components/com_wallfactory/models/forms/configuration/' . $name . '.xml');

        WallFactoryForm::addLabelsToForm($form);
    }
}
