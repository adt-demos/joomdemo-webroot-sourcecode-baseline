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

class LikeController extends BaseController
{
    public function index()
    {
        $resourceType = $this->input->getCmd('type');
        $resourceId = $this->input->getInt('id');

        $model = new \WallFactoryFrontendModelLikes();

        $likes = $model->findLikes($resourceType, $resourceId);

        return $this->render('like.index', array(
            'likes' => $likes,
        ));
    }

    public function submit()
    {
        $response = array();
        $resourceType = $this->input->getCmd('type');
        $resourceId = $this->input->getInt('id');
        $user = \JFactory::getUser();

        $model = new \WallFactoryFrontendModelLike();

        try {
            $model->submit($resourceType, $resourceId, $user->id);

            $response['success'] = true;
            $response['html'] = \JHtml::_('WallFactory.like', true, $resourceType, $resourceId);
            $response['message'] = \WallFactoryText::_('like_task_submit_success');
            $response['likes'] = $this->getLikes($resourceType, $resourceId);
            $response['resource']['type'] = $resourceType;
            $response['resource']['id'] = $resourceId;
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('like_task_submit_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    private function getLikes($resourceType, $resourceId)
    {
        $repo = new \WallFactoryFrontendModelLikes();

        $totals = $repo->countForResources($resourceType, array($resourceId));
        $total = isset($totals[$resourceId]['likes']) ? $totals[$resourceId]['likes'] : 0;

        return \JHtml::_('WallFactory.likes', $total, $resourceType, $resourceId);
    }

    public function remove()
    {
        $response = array();
        $resourceType = $this->input->getCmd('type');
        $resourceId = $this->input->getInt('id');
        $user = \JFactory::getUser();

        $model = new \WallFactoryFrontendModelLike();

        try {
            $model->remove($resourceType, $resourceId, $user->id);

            $response['success'] = true;
            $response['html'] = \JHtml::_('WallFactory.like', false, $resourceType, $resourceId);
            $response['message'] = \WallFactoryText::_('like_task_remove_success');
            $response['likes'] = $this->getLikes($resourceType, $resourceId);
            $response['resource']['type'] = $resourceType;
            $response['resource']['id'] = $resourceId;
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('like_task_remove_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function latest($user_id)
    {
        $repo = new \WallfactoryFrontendModelPosts();
        $posts = $repo->findLatestLikedByUser($user_id, 20);

        return $this->render('post._list', array(
            'posts'    => $posts,
            'comments' => false,
        ));
    }
}
