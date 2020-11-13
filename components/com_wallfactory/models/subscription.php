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

class WallFactoryFrontendModelSubscription extends JModelLegacy
{
    public function register($userId, $subscriberId)
    {
        // Check if user is logged in.
        if (!$subscriberId) {
            throw new Exception(WallFactoryText::_('subscription_register_error_guests_not_allowed'));
        }

        // Check if the user has already a subscription.
        $subscription = WallFactoryTable::getInstance('Subscription');
        $data = array(
            'subscriber_id' => $subscriberId,
            'user_id'       => $userId,
        );
        $subscription->load($data);

        if ($subscription->id) {
            throw new Exception(WallFactoryText::_('subscription_register_error_already_subscribed'));
        }

        // Submit the like.
        $subscription->save($data);
    }

    public function cancel($userId, $subscriberId)
    {
        // Check if user is logged in.
        if (!$userId) {
            throw new Exception(WallFactoryText::_('subscription_cancel_error_guests_not_allowed'));
        }

        // Check if the user has subscribed.
        $subscription = WallFactoryTable::getInstance('Subscription');
        $data = array(
            'subscriber_id' => $subscriberId,
            'user_id'       => $userId,
        );
        $subscription->load($data);

        if (!$subscription->id) {
            throw new Exception(WallFactoryText::_('subscription_cancel_error_not_subscribed'));
        }

        // Remove the like.
        $subscription->delete($subscription->id);
    }

    public function notification($userId, $subscriberId)
    {
        // Check if user is logged in.
        if (!$subscriberId) {
            throw new Exception(WallFactoryText::_('subscription_notification_error_guests_not_allowed'));
        }

        // Check if subscription exists.
        $subscription = WallFactoryTable::getInstance('Subscription');
        $data = array(
            'subscriber_id' => $subscriberId,
            'user_id'       => $userId,
        );
        $subscription->load($data);

        if (!$subscription->id) {
            throw new Exception(WallFactoryText::_('subscription_notification_error_subscription_not_found'));
        }

        // Toggle subscription notification.
        $subscription->notification = (integer)!$subscription->notification;
        $subscription->store();
    }
}
