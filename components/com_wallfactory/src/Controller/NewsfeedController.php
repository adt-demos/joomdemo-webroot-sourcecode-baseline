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

class NewsfeedController extends BaseController
{
    public function index(\JUser $user)
    {
        $profileRepo = new \WallFactoryFrontendModelProfile();

        $toProfile = $profileRepo->findOrCreate($user->id);

        $limitstart = $this->input->getInt('limitstart', 0);
        $comments = $this->configuration->get('comment.enabled', 1);

        return $this->render('newsfeed.index', array(
            'limitstart' => $limitstart,
            'comments'   => $comments,
            'userId'     => $user->id,
            'toProfile'  => $toProfile,
        ));
    }

    public function posts()
    {
        $userId = \JFactory::getUser()->id;

        $limit = $this->configuration->get('newsfeed.limit', 2);
        $comments = $this->input->getBool('comments', true);
        $limitstart = $this->input->getInt('limitstart', 0);

        $repo = new \WallFactoryFrontendModelNewsFeed();

        $posts = $repo->fetch($userId, null, $limitstart, $limit);
        $total = $repo->count($userId);
        $dataUrl = \WallFactoryRoute::raw('newsfeed.load');

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
        $userId = \JFactory::getUser()->id;
        $comments = $this->input->getBool('comments', true);
        $timestamp = $this->input->getString('timestamp');

        $repo = new \WallFactoryFrontendModelNewsFeed();
        $posts = $repo->fetch($userId, $timestamp);

        return $this->render('post._list', array(
            'posts'    => $posts,
            'comments' => $comments,
        ));
    }
}
