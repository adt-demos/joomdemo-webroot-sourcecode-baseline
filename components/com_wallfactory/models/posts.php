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

class WallFactoryFrontendModelPosts extends JModelLegacy
{
    /** @var JUser */
    protected $user;

    public function __construct(array $config = array())
    {
        parent::__construct($config);

        if (isset($config['user'])) {
            $this->user = $config['user'];
        }
        else {
            $this->user = JFactory::getUser();
        }
    }

    public function findLatestByUser($userId, $limit = 5)
    {
        $dbo = $this->getDbo();
        $query = $this->getPostsQuery();

        $conditions = array();

        // Posts submitted by the user.
        $conditions[] = $dbo->qn('p.user_id') . ' = ' . $dbo->q($userId);

        $query->where('(' . implode(' OR ', $conditions) . ')');

        $results = $dbo->setQuery($query, 0, $limit)
            ->loadObjectList();

        return $this->parse($results);
    }

    protected function getPostsQuery()
    {
        $dbo = $this->getDbo();

        $post = WallFactoryTable::getInstance('Post');

        $query = $dbo->getQuery(true)
            ->select('p.*')
            ->from($dbo->qn($post->getTableName(), 'p'))
            ->where($dbo->qn('p.published') . ' = ' . $dbo->q(1))
            ->order($dbo->qn('p.created_at') . ' DESC');

        return $query;
    }

    protected function parse($posts)
    {
        if (!$posts) {
            return $posts;
        }

        $this->parseSubscriptions($posts);
        $this->parseProfileData($posts);
        $this->parseLikes($posts);
        $this->parseMedia($posts);

        return $posts;
    }

    private function parseSubscriptions($posts)
    {
        $repo = new WallFactoryFrontendModelSubscriptions(array('dbo' => $this->getDbo()));
        $users = array();

        foreach ($posts as $post) {
            if ($post->user_id) {
                $users[] = (int)$post->user_id;
            }
        }

        $subscriptions = $repo->findUserSubscriptionsToUsers($this->user->id, $users);

        foreach ($posts as $post) {
            $post->subscribed = isset($subscriptions[$post->user_id]);
        }
    }

    private function parseProfileData($posts)
    {
        $repo = new WallFactoryFrontendModelProfiles(array('dbo' => $this->getDbo()));
        $users = array();

        foreach ($posts as $post) {
            if ($post->user_id) {
                $users[] = (int)$post->user_id;
            }

            $users[] = (int)$post->to_user_id;
        }

        $profiles = $repo->findProfileDisplayByIds(array_unique($users));

        foreach ($posts as $post) {
            if ($post->user_id) {
                $profile = isset($profiles[$post->user_id]) ? $profiles[$post->user_id] : null;

                $post->avatar_source = $profile ? $profile['avatar_source'] : null;
                $post->thumbnail = $profile ? $profile['thumbnail'] : null;
                $post->name = $profile ? $profile['name'] : null;
            }
            else {
                $post->name = $post->author_name;
            }

            if (isset($profiles[$post->to_user_id])) {
                $post->to_name = $profiles[$post->to_user_id]['name'];
            }
        }
    }

    private function parseLikes($posts)
    {
        $repo = new WallFactoryFrontendModelLikes(array('dbo' => $this->getDbo()));
        $user = JFactory::getUser();

        $ids = array();
        foreach ($posts as $post) {
            $ids[] = $post->id;
        }

        $totals = $repo->countForResources('post', $ids);
        $likes = $repo->findByUserForResources($user->id, 'post', $ids);

        foreach ($posts as $post) {
            $post->likes = new stdClass();

            $post->likes->total = isset($totals[$post->id]) ? $totals[$post->id]['likes'] : 0;
            $post->likes->liked = isset($likes[$post->id]);
        }
    }

    private function parseMedia($posts)
    {
        $repo = new WallFactoryFrontendModelMedia(array('dbo' => $this->getDbo()));
        $ids = array();

        foreach ($posts as $post) {
            $ids[] = $post->id;
        }

        $media = $repo->findForPosts($ids);

        foreach ($posts as $post) {
            if (isset($media[$post->id])) {
                $post->media = $media[$post->id];
            }
            else {
                $post->media = array();
            }
        }
    }

    public function findLatestLikedByUser($userId, $limit = 10)
    {
        $dbo = $this->getDbo();
        $query = $this->getPostsQuery();

        $like = WallFactoryTable::getInstance('Like');

        $query
            ->leftJoin($dbo->qn($like->getTableName(), 'l') . ' ON l.resource_type = ' . $dbo->q('post') . ' AND l.resource_id = p.id AND l.user_id = ' . $dbo->q($userId))
            ->where('l.id IS NOT NULL');

        $results = $dbo->setQuery($query, 0, $limit)
            ->loadObjectList();

        return $this->parse($results);
    }

    public function findOne($id)
    {
        $dbo = $this->getDbo();
        $post = WallFactoryTable::getInstance('Post');

        $query = $dbo->getQuery(true)
            ->select('p.*')
            ->from($dbo->qn($post->getTableName(), 'p'))
            ->where($dbo->qn('p.published') . ' = ' . $dbo->q(1))
            ->where($dbo->qn('p.id') . ' = ' . $dbo->q($id));

        $result = $dbo->setQuery($query)
            ->loadObject();

        return $result;
    }

    public function findById($id)
    {
        $dbo = $this->getDbo();
        $query = $this->getPostsQuery();

        $conditions = array();

        // Posts submitted by the user.
        $conditions[] = $dbo->qn('p.id') . ' = ' . $dbo->q($id);

        $query->where('(' . implode(' OR ', $conditions) . ')');

        $results = $dbo->setQuery($query, 0, 1)
            ->loadObjectList();

        if (!$results) {
            return null;
        }

        $results = $this->parse($results);

        return $results[0];
    }

    public function findReceivedByUser($id)
    {
        /** @var WallFactoryTablePost $post */

        $dbo = $this->getDbo();
        $post = WallFactoryTable::getInstance('Post');

        $query = $dbo->getQuery(true)
            ->select('p.*')
            ->from($dbo->qn($post->getTableName(), 'p'))
            ->where($dbo->qn('p.to_user_id') . ' = ' . $dbo->q($id));

        $results = $dbo->setQuery($query)
            ->loadObjectList('id', get_class($post));

        return $results;
    }

    public function findAllByUser($id)
    {
        /** @var WallFactoryTablePost $post */

        $dbo = $this->getDbo();
        $post = WallFactoryTable::getInstance('Post');

        $query = $dbo->getQuery(true)
            ->select('p.*')
            ->from($dbo->qn($post->getTableName(), 'p'))
            ->where($dbo->qn('p.user_id') . ' = ' . $dbo->q($id), 'OR')
            ->where($dbo->qn('p.to_user_id') . ' = ' . $dbo->q($id));

        $results = $dbo->setQuery($query)
            ->loadObjectList('id', get_class($post));

        return $results;
    }
}
