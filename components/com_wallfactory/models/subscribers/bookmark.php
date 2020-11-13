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

class WallFactoryEventSubscriberBookmark extends \Joomla\Event\Event
{
    public static function getSubscribedEvents()
    {
        return array(
            'onBookmarkRemoved',
            'onBookmarkBeforeSave',
            'onBookmarkAfterSave',
        );
    }

    public static function onBookmarkRemoved($context, $bookmark = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $bookmark) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$bookmark instanceof WallFactoryTableBookmark) {
            return null;
        }

        jimport('joomla.filesystem.file');
        $path = JPATH_SITE . '/media/com_wallfactory/bookmarks/' . $bookmark->thumbnail;

        if (!JFile::exists($path)) {
            return null;
        }

        if (!JFile::delete($path)) {
            return null;
        }

        return null;
    }

    public static function onBookmarkBeforeSave($context, $data = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $data) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context) {
            return null;
        }

        if (!isset($data['upload']) || 0 != $data['upload']['error'] || !$data['id']) {
            return null;
        }

        /** @var WallFactoryTableBookmark $bookmark */
        $bookmark = WallFactoryTable::getInstance('Bookmark');

        if (!$bookmark->load($data['id'])) {
            return null;
        }

        jimport('joomla.filesystem.file');
        $path = JPATH_SITE . '/media/com_wallfactory/bookmarks/' . $bookmark->thumbnail;

        if (!JFile::exists($path)) {
            return null;
        }

        if (!JFile::delete($path)) {
            return null;
        }

        $bookmark->save(array(
            'thumbnail' => '',
        ));

        return null;
    }

    public static function onBookmarkAfterSave($context, $data = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $data) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context) {
            return null;
        }

        if (!isset($data['upload']) || 0 != $data['upload']['error'] || !$data['id']) {
            return null;
        }

        /** @var WallFactoryTableBookmark $bookmark */
        $bookmark = WallFactoryTable::getInstance('Bookmark');

        if (!$bookmark->load($data['id'])) {
            return null;
        }

        $imagine = new \Imagine\Gd\Imagine();
        $image = $imagine->open($data['upload']['tmp_name']);

        $size = 32;

        if ($image->getSize()->getHeight() > $image->getSize()->getWidth()) {
            $image->resize($image->getSize()->widen($size));
            $point = new \Imagine\Image\Point(0, ($image->getSize()->getHeight() - $size) / 2);
        }
        else {
            $image->resize($image->getSize()->heighten($size));
            $point = new \Imagine\Image\Point(($image->getSize()->getWidth() - $size) / 2, 0);
        }

        $extension = strtolower(pathinfo($data['upload']['name'], PATHINFO_EXTENSION));
        $filename = $data['id'] . '.' . $extension;
        $path = JPATH_SITE . '/media/com_wallfactory/bookmarks';

        $image->crop($point, new \Imagine\Image\Box($size, $size))
            ->save($path . '/' . $filename, array('jpeg_quality' => 100));

        $bookmark->save(array(
            'thumbnail' => $filename,
        ));

        return null;
    }
}
