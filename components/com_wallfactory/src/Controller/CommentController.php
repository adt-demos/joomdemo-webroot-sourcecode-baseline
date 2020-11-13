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

class CommentController extends BaseController
{
    public function index()
    {
        $postId = $this->input->getInt('post_id');
        $limit = $this->configuration->get('comment.limit', 4);

        $repo = new \WallFactoryFrontendModelComments();

        $comments = $repo->getItems($postId, $limit + 1);
        $hasMore = count($comments) > $limit;

        if ($hasMore) {
            array_pop($comments);
        }

        return $this->render('comment.index', array(
            'postId'   => $postId,
            'comments' => $comments,
            'hasMore'  => $hasMore,
        ));
    }

    public function form()
    {
        $user = \JFactory::getUser();
        $postId = $this->input->getInt('post_id');

        $profileRepo = new \WallFactoryFrontendModelProfiles();
        $comment = new \WallFactoryFrontendModelComment();

        $form = $comment->getForm();
        $profile = $profileRepo->findOne($user->id);

        $form->bind(array(
            'post_id' => $postId,
        ));

        return $this->render('comment._form', array(
            'profile' => $profile,
            'form'    => $form,
        ));
    }

    public function load()
    {
        $limit = $this->configuration->get('comment.load', 10);

        $postId = $this->input->getInt('post_id');
        $timestamp = $this->input->getString('timestamp');
        $direction = $this->input->getString('direction');

        $repo = new \WallFactoryFrontendModelComments();

        $comments = $repo->getItems($postId, $limit, $timestamp, $direction);
        $total = $repo->count($postId, $timestamp, $direction);

        $hasMore = $total > count($comments);

        return $this->render('comment.index', array(
            'postId'   => $postId,
            'comments' => $comments,
            'hasMore'  => $hasMore,
        ));
    }

    public function submit()
    {
        $response = array();
        $user = \JFactory::getUser();
        $comment = $this->input->post->get('comment', array(), 'array');

        $comment['user_id'] = $user->id;
        $model = new \WallFactoryFrontendModelComment();

        try {
            $model->submit($comment);

            $response['success'] = true;
            $response['message'] = \WallFactoryText::_('comment_task_submit_success');
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('comment_task_submit_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function delete()
    {
        $response = array();
        $user = \JFactory::getUser();
        $id = $this->input->getInt('id');

        $model = new \WallFactoryFrontendModelComment();

        try {
            $model->delete($user, $id);

            $response['success'] = true;
            $response['message'] = \WallFactoryText::_('comment_task_delete_success');
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('comment_task_delete_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function show($id)
    {
        $repo = new \WallFactoryFrontendModelComments();
        $comment = $repo->findById($id);

        return $this->render('comment.show', array(
            'comment' => $comment,
        ));
    }
}
