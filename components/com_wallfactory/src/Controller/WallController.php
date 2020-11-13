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

class WallController extends BaseController
{
    public function show(\JUser $user, $limitstart = 0)
    {
        $userId = $this->input->getInt('user_id', $user->id);
        $comments = $this->configuration->get('comment.enabled', 1);

        $profileRepo = new \WallFactoryFrontendModelProfile();

        $toProfile = $profileRepo->findOrCreate($userId);

        return $this->render('wall.show', array(
            'toProfile'  => $toProfile,
            'comments'   => $comments,
            'limitstart' => $limitstart,
        ));
    }

    public function posts($userId, $limitstart, $comments)
    {
        $limit = $this->configuration->get('post.limit', 10);

        $repo = new \WallFactoryFrontendModelWall();

        $posts = $repo->fetch($userId, $limitstart, $limit);
        $total = $repo->count($userId);

        $dataUrl = \WallFactoryRoute::raw('wall.load&user_id=' . $userId);
        $pagination = new \JPagination($total, $limitstart, $limit);

        return $this->render('post.index', array(
            'posts'      => $posts,
            'comments'   => $comments,
            'dataUrl'    => $dataUrl,
            'pagination' => $pagination,
        ));
    }

    public function load()
    {
        $userId = $this->input->getInt('user_id');
        $timestamp = $this->input->getString('timestamp');
        $comments = $this->configuration->get('comment.enabled', 1);

        $repo = new \WallFactoryFrontendModelWall();

        $posts = $repo->fetch($userId, 0, 0, $timestamp);

        return $this->render('post._list', array(
            'posts'    => $posts,
            'comments' => $comments,
        ));
    }

    public function cb(\JUser $user)
    {
        $repo = new \WallFactoryFrontendModelWall();
        $profileRepo = new \WallFactoryFrontendModelProfile();

        $limit = $this->configuration->get('post.limit', 20);

        $posts = $repo->fetch($user->id, 0, $limit);
        $toProfile = $profileRepo->find($user->id);

        $dataUrl = \WallFactoryRoute::raw('wall.load&user_id=' . $user->id);

        return $this->render('post.cb', array(
            'posts'     => $posts,
            'toProfile' => $toProfile,
            'dataUrl'   => $dataUrl,
        ));
    }
}
