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

class WallFactoryUpgrade
{
    public static function check()
    {
        if (!self::backupExists()) {
            return false;
        }

        JFactory::getApplication()->enqueueMessage(
            <<<HTML
            <p>Backup data was found! If you chose to restore it, please take note that your current data will be removed!</p>
<a href="index.php?option=com_wallfactory&task=upgrade.restore" class="btn btn-small btn-primary" onclick="return confirm('Are you sure you want to restore the backup data? This will remove all your current data!');">Restore backup</a>
<a href="index.php?option=com_wallfactory&task=upgrade.delete" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to remove the backup data? This operation cannot be undone!');">Remove backup</a>
HTML
        );
    }

    public static function backupExists()
    {
        $session = JFactory::getSession();
        $sessionName = 'com_wallfactory.backup.exists';

        if (false === $session->get($sessionName, true)) {
            return false;
        }

        try {
            $dbo = JFactory::getDbo();
            $dbo->getTableColumns('#__wallfactory_walls');

            return true;
        } catch (Exception $e) {
        }

        $session->set($sessionName, false);

        return false;
    }

    public static function restore()
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        self::truncateTables();

        self::restoreBookmarks();
        self::restoreComments();
        self::restoreFollowers();
        self::restoreMedia();
        self::restoreUrls();
        self::restoreMembers();
        self::restorePosts();
        self::restoreWalls();
    }

    private static function truncateTables()
    {
        $dbo = JFactory::getDbo();
        $tables = array(
            'Bookmark',
            'Comment',
            'Like',
            'Media',
            'MediaAudio',
            'MediaFile',
            'MediaLink',
            'MediaPhoto',
            'MediaVideo',
            'Notification',
            'Post',
            'Profile',
            'Report',
            'Subscription',
        );

        foreach ($tables as $table) {
            $name = JTable::getInstance($table, 'WallFactoryTable')->getTableName();
            $dbo->truncateTable($name);
        }
    }

    private static function restoreBookmarks()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('b.*')
            ->from('#__wallfactory_bookmarks b');
        $bookmarks = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($bookmarks as $i => $bookmark) {
            $table = WallFactoryTable::getInstance('Bookmark');

            $table->bind(array(
                'id'        => $bookmark['id'],
                'title'     => $bookmark['title'],
                'link'      => preg_replace('/%%(.+)%%/U', '{{ $1 }}', $bookmark['link']),
                'thumbnail' => $bookmark['id'] . '.' . $bookmark['extension'],
                'published' => $bookmark['published'],
                'ordering'  => $i,
            ));

            $dbo->insertObject($table->getTableName(), $table);

            $file = JPATH_SITE . '/media/com_wallfactory/backup/bookmarks/' . $table->thumbnail;

            if (JFile::exists($file)) {
                $dest = JPATH_SITE . '/media/com_wallfactory/bookmarks/' . $table->thumbnail;
                JFile::copy($file, $dest);
            }
        }
    }

    private static function restoreComments()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('c.*')
            ->from('#__wallfactory_comments c');
        $comments = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($comments as $i => $comment) {
            $table = WallFactoryTable::getInstance('Comment');

            $table->bind(array(
                'id'          => $comment['id'],
                'post_id'     => $comment['post_id'],
                'user_id'     => $comment['user_id'],
                'content'     => $comment['content'],
                'author_name' => $comment['author_name'],
                'published'   => $comment['approved'],
                'updated_at'  => $comment['date_created'],
                'created_at'  => $comment['date_created'],
            ));

            $dbo->insertObject($table->getTableName(), $table);
        }
    }

    private static function restoreFollowers()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('f.*')
            ->from('#__wallfactory_followers f');

        $query->select('w.user_id AS wall_user_id')
            ->leftJoin('#__wallfactory_walls w ON w.id = f.wall_id');

        $results = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($results as $i => $result) {
            $table = WallFactoryTable::getInstance('Subscription');

            $table->bind(array(
                'id'            => $result['id'],
                'subscriber_id' => $result['user_id'],
                'user_id'       => $result['wall_user_id'],
                'notification'  => $result['notification'],
                'created_at'    => $result['date_created'],
            ));

            $dbo->insertObject($table->getTableName(), $table);
        }
    }

    private static function restoreMedia()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('m.*')
            ->from('#__wallfactory_media m');

        $results = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($results as $i => $result) {
            $type = self::mediaFolderToType($result['folder']);

            if (null === $type) {
                continue;
            }

            $table = WallFactoryTable::getInstance('Media' . ucfirst($type));

            $table->bind(array(
                'id' => $result['id'],
            ));

            $table->bind(array(
                'post_id'     => $result['post_id'],
                'title'       => $result['title'],
                'description' => null,
                'path'        => $table->getFolder(),
                'filename'    => $result['name'] . '.' . $result['extension'],
            ));

            $dbo->insertObject($table->getTableName(), $table);

            $media = WallFactoryTable::getInstance('Media');

            $media->bind(array(
                'id'         => null,
                'post_id'    => $result['post_id'],
                'media_type' => $type,
                'media_id'   => $table->id,
                'ordering'   => $i,
            ));

            $dbo->insertObject($media->getTableName(), $media);

            $src = JPATH_SITE . '/media/com_wallfactory/storage/users/' . $result['user_id'] . '/' . $result['folder'] . '/' . $table->filename;
            $folder = JPATH_SITE . '/media/com_wallfactory/storage/media/' . $type . '/' . $table->getFolder();
            $dest = $folder . '/' . $table->filename;

            if (JFolder::exists($folder)) {
                JFolder::delete($folder);
            }

            JFolder::create($folder);

            JFile::copy($src, $dest);

            if ('photo' === $type) {
                JFile::copy($src, $folder . '/thumbnail-' . $table->filename);
            }
        }
    }

    private static function mediaFolderToType($folder)
    {
        $mappings = array(
            'images' => 'photo',
            'mp3'    => 'audio',
            'files'  => 'file',
        );

        return isset($mappings[$folder]) ? $mappings[$folder] : null;
    }

    private static function restoreUrls()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('*')
            ->from('#__wallfactory_urls');

        $results = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($results as $i => $result) {
            // Link media.
            if ($result['url']) {
                $link = WallFactoryTable::getInstance('MediaLink');

                $url = 0 !== strpos($result['url'], 'http') ? 'http://' . $result['url'] : $result['url'];

                $link->bind(array(
                    'id'          => null,
                    'post_id'     => $result['post_id'],
                    'url'         => $url,
                    'title'       => $result['url_title'],
                    'description' => $result['url_description'],
                ));

                $dbo->insertObject($link->getTableName(), $link);

                $media = WallFactoryTable::getInstance('Media');

                $media->bind(array(
                    'id'         => null,
                    'post_id'    => $result['post_id'],
                    'media_type' => 'link',
                    'media_id'   => $dbo->insertid(),
                    'ordering'   => $media->getNextOrder($dbo->qn('post_id') . ' = ' . $dbo->q($result['post_id'])),
                ));

                $dbo->insertObject($media->getTableName(), $media);
            }

            // Video media.
            if ($result['video_id']) {
                $video = WallFactoryTable::getInstance('MediaVideo');

                $url = 0 !== strpos($result['video_link'], 'http') ? 'http://' . $result['video_link'] : $result['video_link'];

                $video->bind(array(
                    'id'          => null,
                    'post_id'     => $result['post_id'],
                    'url'         => $url,
                    'player'      => null,
                    'title'       => $result['video_title'],
                    'description' => $result['video_description'],
                    'thumbnail'   => $result['video_thumbnail'],
                ));

                $dbo->insertObject($video->getTableName(), $video);

                $media = WallFactoryTable::getInstance('Media');

                $media->bind(array(
                    'id'         => null,
                    'post_id'    => $result['post_id'],
                    'media_type' => 'video',
                    'media_id'   => $dbo->insertid(),
                    'ordering'   => $media->getNextOrder($dbo->qn('post_id') . ' = ' . $dbo->q($result['post_id'])),
                ));

                $dbo->insertObject($media->getTableName(), $media);
            }
        }
    }

    private static function restoreMembers()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('m.*')
            ->from('#__wallfactory_members m');

        $query->select('u.name AS joomla_name')
            ->leftJoin('#__users u ON u.id = m.user_id');

        $results = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($results as $i => $result) {
            $table = WallFactoryTable::getInstance('Profile');

            $table->bind(array(
                'user_id'       => $result['user_id'],
                'name'          => $result['name'] ? $result['name'] : $result['joomla_name'],
                'description'   => $result['description'],
                'avatar_source' => 'none',
                'thumbnail'     => null,
                'notifications' => null,
                'created_at'    => null,
            ));

            $dbo->insertObject($table->getTableName(), $table);
        }
    }

    private static function restorePosts()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('p.*')
            ->from('#__wallfactory_posts p');

        $query->select('w.user_id AS wall_user_id')
            ->leftJoin('#__wallfactory_walls w ON w.id = p.wall_id');

        $results = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($results as $i => $result) {
            $table = WallFactoryTable::getInstance('Post');

            $table->bind(array(
                'id'           => $result['id'],
                'user_id'      => $result['user_id'],
                'to_user_id'   => $result['wall_user_id'],
                'content'      => $result['content'],
                'author_name'  => null,
                'author_email' => null,
                'published'    => 1,
                'created_at'   => $result['date_created'],
            ));

            $dbo->insertObject($table->getTableName(), $table);
        }
    }

    private static function restoreWalls()
    {
        $dbo = JFactory::getDbo();

        $query = $dbo->getQuery(true)
            ->select('w.*')
            ->from('#__wallfactory_walls w');

        $query->select('u.name AS joomla_name')
            ->leftJoin('#__users u ON u.id = w.user_id');

        $results = $dbo->setQuery($query)
            ->loadAssocList();

        foreach ($results as $i => $result) {
            $profile = WallFactoryTable::getInstance('Profile');

            if ($profile->load($result['user_id'])) {
                continue;
            }

            $table = WallFactoryTable::getInstance('Profile');

            $table->bind(array(
                'user_id'       => $result['user_id'],
                'name'          => $result['title'] ? $result['title'] : $result['joomla_name'],
                'description'   => null,
                'avatar_source' => 'none',
                'thumbnail'     => null,
                'notifications' => null,
                'created_at'    => null,
            ));

            $dbo->insertObject($table->getTableName(), $table);
        }
    }

    public static function delete()
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        self::removeTables();
        self::removeStorage();

        $session = JFactory::getSession();
        $sessionName = 'com_wallfactory.backup.exists';

        $session->set($sessionName, false);
    }

    private static function removeTables()
    {
        $dbo = JFactory::getDbo();
        $tables = array(
            '#__wallfactory_bookmarks',
            '#__wallfactory_comments',
            '#__wallfactory_followers',
            '#__wallfactory_ips',
            '#__wallfactory_media',
            '#__wallfactory_members',
            '#__wallfactory_posts',
            '#__wallfactory_statistics',
            '#__wallfactory_urls',
            '#__wallfactory_walls',
        );

        foreach ($tables as $table) {
            $dbo->dropTable($table);
        }
    }

    private function removeStorage()
    {
        $folder = JPATH_SITE . '/media/com_wallfactory/storage/users';

        if (JFolder::exists($folder)) {
            JFolder::delete($folder);
        }

        $folder = JPATH_SITE . '/media/com_wallfactory/backup';

        if (JFolder::exists($folder)) {
            JFolder::delete($folder);
        }
    }
}
