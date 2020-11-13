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

use Joomla\CMS\Component\ComponentHelper;
use ThePhpFactory\Wall\Firewall\ProfileNotFilledException;

class ProfileController extends BaseController
{
    public function show(\JUser $user)
    {
        $id = $this->input->getInt('id', (int)$user->id);
        $isMyProfile = !$user->guest && $id === (int)$user->id;

        $profileRepo = new \WallfactoryFrontendModelProfiles();
        $notificationsModel = new \WallFactoryFrontendModelNotifications();

        $profile = $profileRepo->findOne($id);

        if (!$profile) {
            if ($isMyProfile) {
                throw new ProfileNotFilledException();
            }

            return $this->render('profile._not_found');
        }

        $hasNotifications = (boolean)$notificationsModel->getEnabledNotifications();
        $allowSelfProfileRemoval = $this->configuration->get('profile.self_removal', 0);

        $config = ComponentHelper::getParams('com_wallfactory');
        $canUploadAvatar = \WallFactoryAvatar::canUploadAvatar();

        return $this->render('profile.show', [
            'profile'                 => $profile,
            'hasNotifications'        => $hasNotifications,
            'isMyProfile'             => $isMyProfile,
            'allowSelfProfileRemoval' => $allowSelfProfileRemoval,
            'config'                  => $config,
            'canUploadAvatar'         => $canUploadAvatar,
        ]);
    }

    public function delete()
    {
        if ('POST' === $this->input->getMethod()) {
            \JSession::checkToken() or jexit(\JText::_('JINVALID_TOKEN'));

            $user = \JFactory::getUser();
            $model = new \WallFactoryFrontendModelProfile();

            try {
                $model->delete((int)$user->id);

                $menu = \JFactory::getApplication()->getMenu();
                $default = $menu->getDefault();

                $this->setMessage(\WallFactoryText::_('profile_delete_task_success'));

                $redirect = \JRoute::_($default->link . '&Itemid=' . $default->id, false);
            }
            catch (\Exception $e) {
                $this->setMessage($e->getMessage(), 'error');

                $redirect = \WallFactoryRoute::task('profile.delete');
            }

            $this->redirect($redirect);
        }

        return $this->render('profile.delete');
    }

    public function update(\JUser $user, $notice = 0)
    {
        $repo = new \WallFactoryFrontendModelProfile();
        $form = $repo->getForm();

        if ('POST' === $this->input->getMethod()) {
            $profile = $this->input->post->get('profile', [], 'array');
            $profile['user_id'] = $user->id;

            $profile = \WallFactoryForm::validate($form, $profile);

            try {
                $repo->update($profile);

                $this->setMessage(\WallFactoryText::_('profile_task_update_success'));
            }
            catch (\Exception $e) {
                $this->setMessage($e->getMessage(), 'error');
            }

            $this->redirect(\WallFactoryRoute::task('profile.update'));
        }

        if ($notice) {
            $this->setMessage(\WallFactoryText::_('profile_update_profile_first'), 'warning');
        }

        $profile = $repo->find($user->id);

        if (null === $profile) {
            $profile = [
                'name' => $user->name,
            ];
        }

        \WallFactoryForm::bindContextData($form, $profile);

        return $this->render('profile.update', [
            'form' => $form,
        ]);
    }
}
