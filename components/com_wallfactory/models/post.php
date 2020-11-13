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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;

class WallFactoryFrontendModelPost extends JModelLegacy
{
    public function submit(array $data = array())
    {
        $data['content'] = WallFactoryHelper::filterBannedWords($data['content']);
        $user = Factory::getUser();

        $this->throttlePosts($user->id);

        /** @var WallFactoryTablePost $post */
        $post = WallFactoryTable::getInstance('Post');
        $post->save($data);

        if (isset($data['media'])) {
            $this->submitMedia($data['media'], $post);
        }
    }

    private function submitMedia($items, WallFactoryTablePost $post)
    {
        $configuration = JComponentHelper::getParams('com_wallfactory');
        $submitted = array();

        foreach ($items as $ordering => $media) {
            foreach ($media as $type => $value) {
                // Check if media type is enabled.
                if (!$configuration->get('posting.' . $type . '.enabled', 1)) {
                    continue;
                }

                if (is_string($value)) {
                    $value = trim($value);
                }

                if (!isset($submitted[$type])) {
                    $submitted[$type] = 0;
                }

                // Get media type limit.
                $limit = $configuration->get('posting.' . $type . '.limit', 0);

                // Assert media type limit is not reached.
                if ($limit && $submitted[$type] >= $limit) {
                    continue;
                }

                try {
                    if (is_array($value)) {
                        $value = $this->sanitizeInput($value);
                    }

                    $mediaType = \ThePhpFactory\Wall\Media\MediaFactory::build($type);
                    $itemId = $mediaType->submit($post->id, $value);
                } catch (Exception $e) {
                    continue;
                }

                if (!(int)$itemId) {
                    continue;
                }

                /** @var WallFactoryTableMedia $media */
                $media = WallFactoryTable::getInstance('Media');

                $media->save(array(
                    'post_id'    => $post->id,
                    'media_type' => $type,
                    'media_id'   => $itemId,
                    'ordering'   => $ordering,
                ));

                $submitted[$type]++;
            }
        }
    }

    public function delete(JUser $user, $id)
    {
        if ($user->guest) {
            throw new Exception('Guests are not allowed!');
        }

        /** @var WallFactoryTablePost $post */
        $post = WallFactoryTable::getInstance('Post');

        if (!$id || !$post->load($id)) {
            throw new Exception('Post not found!');
        }

        if ($user->id != $post->user_id) {
            throw new Exception('You are not allowed to remove this post!');
        }

        $post->delete();
    }

    private function throttlePosts(int $userId)
    {
        $params = ComponentHelper::getParams('com_wallfactory');

        if (!$params->get('post.throttle.enabled', 0)) {
            return true;
        }

        $limit = $params->get('post.throttle.posts_per_minute', 0);
        $submitted = $this->countPostsSubmittedLastMinute($userId);

        if ($submitted >= $limit) {
            throw new Exception('Post submission is throttled. Try again later.');
        }

        return true;
    }

    private function countPostsSubmittedLastMinute(int $userId)
    {
        $dbo = $this->getDbo();
        $post = WallFactoryTable::getInstance('Post');
        $date = Factory::getDate('-1 minute');

        $query = $dbo->getQuery(true)
            ->select('COUNT(1) AS posts')
            ->from($dbo->qn($post->getTableName(), 'p'))
            ->where($dbo->qn('p.user_id') . ' = ' . $dbo->q($userId))
            ->where($dbo->qn('p.created_at') . ' >' . $dbo->q($date->toSql()));

        return $dbo->setQuery($query)
            ->loadResult();
    }

    private function sanitizeInput(array $input)
    {
        $filter = new Joomla\Filter\InputFilter();

        $sanitize = ['title', 'description'];

        foreach ($sanitize as $field) {
            if (!isset($input[$field])) {
                continue;
            }

            $input[$field] = $filter->clean($input[$field], 'html');
        }

        return $input;
    }
}
