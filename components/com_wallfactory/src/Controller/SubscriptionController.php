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

class SubscriptionController extends BaseController
{
    public function cancel()
    {
        $userId = $this->input->getInt('user_id');
        $user = \JFactory::getUser();
        $response = array();

        $subscription = new \WallFactoryFrontendModelSubscription();

        try {
            $subscription->cancel($userId, $user->id);

            $response['success'] = true;
            $response['html'] = \JHtml::_('WallFactory.subscribe', false, $userId);
            $response['message'] = \WallFactoryText::_('subscription_task_cancel_success');
            $response['user_id'] = $userId;
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('subscription_task_cancel_error');
            $response['error'] = $e->getMessage();
        }

        if ($this->isXmlHttpRequest()) {
            return json_encode($response);
        }

        $this->setMessage($response['message'], !$response['success'] ? 'error' : 'message');

        $redirect = \WallFactoryRoute::task('subscription');

        $this->redirect($redirect);
    }

    public function notification()
    {
        $userId = $this->input->getInt('user_id');
        $user = \JFactory::getUser();

        $subscription = new \WallFactoryFrontendModelSubscription();

        try {
            $subscription->notification($userId, $user->id);

            $msg = \WallFactoryText::_('subscription_task_notification_success');
            $msgType = 'message';
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $msgType = 'error';
        }

        $redirect = \WallFactoryRoute::task('subscription');

        $this->setMessage($msg, $msgType);

        $this->redirect($redirect, $msg, $msgType);
    }

    public function register()
    {
        $response = array();
        $userId = $this->input->getInt('user_id');
        $user = \JFactory::getUser();

        $subscription = new \WallFactoryFrontendModelSubscription();

        try {
            $subscription->register($userId, $user->id);

            $response['success'] = true;
            $response['html'] = \JHtml::_('WallFactory.subscribe', true, $userId);
            $response['message'] = \WallFactoryText::_('subscription_task_register_success');
            $response['user_id'] = $userId;
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('subscription_task_register_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function index()
    {
        $user = \JFactory::getUser();
        $model = new \WallFactoryFrontendModelSubscriptions();

        $subscriptions = $model->findAll($user->id);

        return $this->render('subscription.index', array(
            'subscriptions' => $subscriptions,
        ));
    }

    public function latest(\JUser $user, $user_id)
    {
        $repo = new \WallFactoryFrontendModelSubscriptions();

        $subscriptions = $repo->findAll($user_id, 20);
        $isMyProfile = $user->id == $user_id;

        return $this->render('subscription.latest', array(
            'subscriptions' => $subscriptions,
            'isMyProfile'   => $isMyProfile,
        ));
    }
}
