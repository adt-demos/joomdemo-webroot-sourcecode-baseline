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

use ThePhpFactory\Wall\Media\MediaFactory;

class PostController extends BaseController
{
    public function all(\JUser $user, $limitstart = 0)
    {
        $comments = $this->configuration->get('comment.enabled', 1);

        $profileRepo = new \WallFactoryFrontendModelProfile();
        $toProfile = $profileRepo->findOrCreate($user->id);

        return $this->render('post.all', array(
            'toProfile'  => $toProfile,
            'comments'   => $comments,
            'limitstart' => $limitstart,
        ));
    }

    public function show($id)
    {
        $repo = new \WallFactoryFrontendModelPosts();

        $comments = $this->configuration->get('comment.enabled', 1);
        $post = $repo->findById($id);

        return $this->render('post.show', array(
            'post'     => $post,
            'comments' => $comments,
        ));
    }

    public function form(\JUser $user, $userId)
    {
        $profileRepo = new \WallFactoryFrontendModelProfiles();

        $profile = $profileRepo->findOne($user->id);
        $config = $this->getFormConfig();
        $mediaTypes = $this->getFormMediaTypes();

        if ((int)$user->id && !(int)$userId) {
            $userId = $user->id;
        }

        if ((int)$user->id === (int)$userId) {
            $placeholder = \WallFactoryText::_('submit_post_placeholder_own_wall');
        }
        else {
            $profileTo = $profileRepo->findOne($userId);
            $placeholder = \WallFactoryText::sprintf('submit_post_placeholder_to_user', $profileTo->name);
        }

        $form = $this->getForm();
        $form->setFieldAttribute('content', 'hint', $placeholder);

        $emoticons = $this->configuration->get('posting.emoticons.enabled', 1);

        return $this->render('post.form', array(
            'profile'    => $profile,
            'profileTo'  => $profile,
            'toUserId'   => $userId,
            'config'     => $config,
            'mediaTypes' => $mediaTypes,
            'form'       => $form,
            'emoticons'  => $emoticons,
        ));
    }

    private function getFormConfig()
    {
        $config = array();

        // Upload max file size.
        $maxSize = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
        $config['upload']['max_file_size']['value'] = $this->return_bytes($maxSize);
        $config['upload']['max_file_size']['error'] = \WallFactoryText::sprintf('media_file_upload_max_size_error', $maxSize);

        // Upload media preview url.
        $config['upload']['url_media_preview'] = \WallFactoryRoute::raw('media.preview&' . \JSession::getFormToken() . '=1');

        return $config;
    }

    private function return_bytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);

        $val = (int)$val;

        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    private function getFormMediaTypes()
    {
        $buttons = array();
        $types = array('link', 'video', 'photo', 'audio', 'file');

        foreach ($types as $type) {
            try {
                $media = MediaFactory::build($type);
            } catch (\Exception $e) {
                continue;
            }

            $buttons[$type] = $media;
        }

        return $buttons;
    }

    private function getForm()
    {
        $form = \JForm::getInstance('com_wallfactory.post', JPATH_SITE . '/components/com_wallfactory/models/forms/post.xml', array(
            'control' => 'post',
        ));

        $user = \JFactory::getUser();

        if (!$user->guest || !$this->configuration->get('post.guest.captcha', 0)) {
            $form->removeField('captcha');
        }

        if (!$user->guest) {
            $form->removeField('author_name');
            $form->removeField('author_email');
        }

        \WallFactoryForm::addLabelsToForm($form);

        return $form;
    }

    public function submit()
    {
        $response = array();
        $user = \JFactory::getUser();
        $post = $this->input->post->get('post', array(), 'array');

        $post['user_id'] = $user->id;

        $model = new \WallFactoryFrontendModelPost();

        try {
            $form = $this->getForm();
            $post = \WallFactoryForm::validate($form, $post);

            $model->submit($post);

            $response['success'] = true;
            $response['message'] = \WallFactoryText::_('post_task_submit_success');
        }
        catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('post_task_submit_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function delete()
    {
        $response = array();
        $user = \JFactory::getUser();
        $id = $this->input->getInt('id');

        $model = new \WallFactoryFrontendModelPost();

        try {
            $model->delete($user, $id);

            $response['success'] = true;
            $response['message'] = \WallFactoryText::_('post_task_delete_success');
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('post_task_delete_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function latest($user_id)
    {
        $repo = new \WallfactoryFrontendModelPosts();
        $posts = $repo->findLatestByUser($user_id, 20);

        return $this->render('post._list', array(
            'posts'    => $posts,
            'comments' => false,
        ));
    }

    public function search($query = '', $limitstart = 0)
    {
        $limit = $this->configuration->get('post.limit', 10);
        $comments = $this->configuration->get('comment.enabled', 1);

        $repo = new \WallFactoryFrontendModelSearch();

        $posts = $repo->fetchAll($query, $limit);
        $total = $repo->count($query);
        $pagination = new \JPagination($total, $limitstart, $limit);

        return $this->render('post.search', array(
            'posts'      => $posts,
            'pagination' => $pagination,
            'comments'   => $comments,
            'query'      => $query,
        ));
    }
}
