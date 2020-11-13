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

class NotificationController extends BaseController
{
    public function index()
    {
        $user = \JFactory::getUser();
        $profileRepo = new \WallFactoryFrontendModelProfile();
        $notificationsModel = new \WallFactoryFrontendModelNotifications();

        $form = $notificationsModel->getForm();
        $profile = $profileRepo->find($user->id);

        \WallFactoryForm::bindContextData(
            $form,
            $profile->notifications
        );

        return $this->render('notification.index', array(
            'form' => $form,
        ));
    }

    public function update()
    {
        $user = \JFactory::getUser();
        $notifications = $this->input->post->get('notifications', array(), 'array');

        $notifications['user_id'] = $user->id;

        $model = new \WallFactoryFrontendModelNotifications();

        try {
            $model->update($notifications);

            $this->setMessage(\WallFactoryText::_('notifications_task_update_success'));
        } catch (\Exception $e) {
            $this->setMessage($e->getMessage(), 'error');
        }

        $this->redirect(\WallFactoryRoute::task('notification.index'));
    }
}
