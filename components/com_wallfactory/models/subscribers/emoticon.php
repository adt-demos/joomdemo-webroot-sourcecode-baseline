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

class WallFactoryEventSubscriberEmoticon extends \Joomla\Event\Event
{
    public static function getSubscribedEvents()
    {
        return array(
            'onEmoticonRemoved',
            'onEmoticonBeforeSave',
            'onEmoticonAfterSave',
        );
    }

    public static function onEmoticonRemoved($context, $emoticon = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $emoticon) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context ||
            !$emoticon instanceof WallFactoryTableEmoticon) {
            return null;
        }

        jimport('joomla.filesystem.file');
        $path = JPATH_SITE . '/media/com_wallfactory/storage/emoticons/' . $emoticon->filename;

        if (!JFile::exists($path)) {
            return null;
        }

        if (!JFile::delete($path)) {
            return null;
        }

        return null;
    }

    public static function onEmoticonBeforeSave($context, $data = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $data) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context) {
            return null;
        }

        if (null === $data['file']) {
            return null;
        }

        /** @var WallFactoryTableEmoticon $emoticon */
        $emoticon = WallFactoryTable::getInstance('Emoticon');

        if (!$emoticon->load($data['id'])) {
            return null;
        }

        jimport('joomla.filesystem.file');
        $path = JPATH_SITE . '/media/com_wallfactory/storage/emoticons/' . $emoticon->filename;

        if (!JFile::exists($path)) {
            return null;
        }

        if (!JFile::delete($path)) {
            return null;
        }

        $emoticon->save(array(
            'filename' => '',
        ));

        return null;
    }

    public static function onEmoticonAfterSave($context, $data = null)
    {
        if ($context instanceof \Joomla\Event\Event) {
            list($context, $data) = $context->getArguments();
        }

        if ('com_wallfactory' !== $context) {
            return null;
        }

        if (null === $data['file']) {
            return null;
        }

        /** @var WallFactoryTableEmoticon $emoticon */
        $emoticon = WallFactoryTable::getInstance('Emoticon');

        if (!$emoticon->load($data['id'])) {
            return null;
        }

        $imagine = new \Imagine\Gd\Imagine();
        $image = $imagine->open($data['file']['tmp_name']);

        $size = 32;

        if ($image->getSize()->getHeight() > $image->getSize()->getWidth()) {
            $image->resize($image->getSize()->widen($size));
        }
        else {
            $image->resize($image->getSize()->heighten($size));
        }

        $extension = strtolower(pathinfo($data['file']['name'], PATHINFO_EXTENSION));
        $name = pathinfo($data['file']['name'], PATHINFO_FILENAME);
        $filename = $data['id'] . '_' . JApplicationHelper::stringURLSafe($name) . '.' . $extension;
        $path = JPATH_SITE . '/media/com_wallfactory/storage/emoticons';

        $image
            ->save($path . '/' . $filename, array('jpeg_quality' => 100));

        $emoticon->save(array(
            'filename' => $filename,
        ));

        return null;
    }
}
