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

class WallFactoryFrontendModelNotifications extends JModelLegacy
{
    public function update(array $data = array())
    {
        $form = $this->getForm();
        $data = WallFactoryForm::validate($form, $data);

        /** @var WallFactoryTableProfile $profile */
        $profile = WallFactoryTable::getInstance('Profile');
        $profile->load($data['user_id']);

        unset($data['user_id']);

        $notifications = new \Joomla\Registry\Registry($data);
        $profile->notifications = $notifications->toString();

        $profile->save(array());
    }

    public function getForm()
    {
        $form = WallFactoryForm::load('notifications');

        foreach ($this->getEnabledNotifications() as $notification) {
            $xml = <<<XML
<form>   
    <fieldset name="details">
        <field name="{$notification['type']}" type="radio" class="switcher btn-group btn-group-yesno" default="1">
            <option value="0">JDISABLED</option>
            <option value="1">JENABLED</option>
        </field>
    </fieldset>
</form>
XML;
            $form->load($xml);
        }

        WallFactoryForm::addLabelsToForm($form);

        return $form;
    }

    public function getEnabledNotifications()
    {
        $configuration = JComponentHelper::getParams('com_wallfactory');
        $notifications = WallFactoryNotification::getNotifications();
        $enabled = array();

        foreach ($notifications as $notification) {
            if ($notification['is_group']) {
                continue;
            }

            if (!$configuration->get('notifications.' . $notification['type'] . '.enabled', 1)) {
                continue;
            }

            $enabled[] = $notification;
        }

        return $enabled;
    }
}
