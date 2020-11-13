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

class WallFactoryEventSubscriberMedia extends \Joomla\Event\Event
{
    public static function onPostRemoved($context, $post = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $post) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$post instanceof WallFactoryTablePost) {
            return null;
        }

        $mediaRepo = new WallFactoryFrontendModelMedia();
        $media = $mediaRepo->findByPost($post->id);

        $message = $media
            ? sprintf('Removing post %d media: %s', $post->id, implode(', ', array_keys($media)))
            : sprintf('Post %d has no media.', $post->id);

        WallFactoryLogger::log($message, 'entity');

        foreach ($media as $item) {
            $item->delete();
        }

        return null;
    }

    public static function onMediaRemoved($context, $media = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $media) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$media instanceof WallFactoryTableMedia) {
            return null;
        }

        $table = WallFactoryTable::getInstance('Media' . ucfirst($media->media_type));

        if ($media->media_id && $table->load($media->media_id)) {
            $table->delete($media->media_id);
        }

        return null;
    }

    public static function onPhotoRemoved($context, $photo = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $photo) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$photo instanceof WallFactoryTableMediaPhoto) {
            return null;
        }

        $media = \ThePhpFactory\Wall\Media\MediaFactory::build('photo');

        self::deleteMediaFolder(
            $media->getBasePath(),
            $photo->path
        );

        return null;
    }

    private static function deleteMediaFolder($basePath, $path)
    {
        jimport('joomla.filesystem.folder');

        $fullPath = $basePath . '/' . $path;

        WallFactoryLogger::log(
            sprintf('REMOVED folder %s', $fullPath),
            'entity'
        );

        if ('' !== $path && JFolder::exists($fullPath)) {
            JFolder::delete($fullPath);
        }
    }

    public static function onAudioRemoved($context, $audio = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $audio) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$audio instanceof WallFactoryTableMediaAudio) {
            return null;
        }

        $media = \ThePhpFactory\Wall\Media\MediaFactory::build('audio');

        self::deleteMediaFolder(
            $media->getBasePath(),
            $audio->path
        );

        return null;
    }

    public static function onFileRemoved($context, $file = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $file) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$file instanceof WallFactoryTableMediaFile) {
            return null;
        }

        $media = \ThePhpFactory\Wall\Media\MediaFactory::build('file');

        self::deleteMediaFolder(
            $media->getBasePath(),
            $file->path
        );

        return null;
    }

    public static function onCronJob($context)
    {
        if ('com_wallfactory' !== $context) {
            return null;
        }

        self::clearTemporaryMedia();
        self::clearCachedMedia();

        return null;
    }

    private static function clearTemporaryMedia()
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $difference = 60 * 60;
        $time = time();
        $tempFolder = realpath(JPATH_SITE . '/tmp/com_wallfactory/media');

        if (false === $tempFolder) {
            return false;
        }

        $files = JFolder::files($tempFolder, '.', true, true);

        foreach ($files as $file) {
            $mtime = filemtime($file);

            if ($difference > $time - $mtime) {
                continue;
            }

            $parent = realpath(dirname(dirname($file)));

            if (false === $parent) {
                continue;
            }

            if (0 !== strpos($parent, $tempFolder)) {
                continue;
            }

            try {
                JFolder::delete($parent);
            } catch (Exception $e) {
                WallFactoryLogger::log(sprintf('Unable to delete %s', $parent), 'cron', JLog::ERROR);
            }
        }

        WallFactoryLogger::log(sprintf('Cleared temporary media folder %s', $tempFolder), 'cron');
    }

    private static function clearCachedMedia()
    {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $difference = 60 * 60 * 24 * 30;
        $time = time();
        $mediaFolder = realpath(JPATH_SITE . '/cache/com_wallfactory/media');

        if (false === $mediaFolder) {
            return false;
        }

        $files = JFolder::files($mediaFolder, '.', true, true);

        foreach ($files as $file) {
            $mtime = filemtime($file);

            if ($difference > $time - $mtime) {
                continue;
            }

            $parent = realpath(dirname(dirname($file)));

            if (false === $parent) {
                continue;
            }

            if (0 !== strpos($parent, $mediaFolder)) {
                continue;
            }

            try {
                JFolder::delete($parent);
            } catch (Exception $e) {
                WallFactoryLogger::log(sprintf('Unable to delete %s', $parent), 'cron', JLog::ERROR);
            }
        }

        WallFactoryLogger::log(sprintf('Cleared cached media folder %s', $mediaFolder), 'cron');
    }
}
