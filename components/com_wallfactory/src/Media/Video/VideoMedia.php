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

namespace ThePhpFactory\Wall\Media\Video;

defined('_JEXEC') or die;

use Embed\Adapters\AdapterInterface;
use Embed\Embed;
use Embed\Request;
use GuzzleHttp\Client;
use ThePhpFactory\Wall\Media\MediaInterface;
use ThePhpFactory\Wall\Media\Video\Adapter\VideoAdapterInterface;

class VideoMedia extends MediaInterface
{
    private static $cachePath = 'cache/com_wallfactory/media/video/thumbnails';
    private $cacheThumbnails = true;

    public static function getCachedPath($thumbnail)
    {
        jimport('joomla.filesystem.file');

        $path = self::getCachePath($thumbnail);

        if (!\JFile::exists(JPATH_SITE . '/' . self::$cachePath . '/' . $path)) {
            return false;
        }

        return \JUri::root() . self::$cachePath . '/' . $path;
    }

    private static function getCachePath($thumbnail)
    {
        $hash = md5($thumbnail);

        return implode('/', array(
            substr($hash, 0, 2),
            substr($hash, 2, 2),
            substr($hash, 4) . '.png',
        ));
    }

    public function submit($postId, $data)
    {
        /** @var \WallFactoryTableMediaVideo $video */
        $video = \WallFactoryTable::getInstance('MediaVideo');
        $media = $this->getInfo($data);

        $video->save(array_merge(
            array('post_id' => $postId),
            $media
        ));

        $this->cacheThumbnail($video->thumbnail);

        return $video->id;
    }

    private function getInfo($data)
    {
        $adapter = $this->getAdapter($data);
        $config = array();

        if ($adapter) {
            $config = array(
                'adapter' => array(
                    'class' => $adapter,
                ),
            );
        }

        $config['resolver'] = array(
            'class' => '\\ThePhpFactory\\Wall\\Media\\Video\\RequestResolver\\Curl',
        );

        /** @var AdapterInterface $info */
        $info = Embed::create($data, $config);

        if (!$info) {
            throw new \Exception('Video type not supported!');
        }

        if ($info instanceof VideoAdapterInterface) {
            $info->setParameters(array(
                'height' => $this->options->get('height', 360),
                'width'  => $this->options->get('width', 620),
            ));
        }

        if (null === $info->getCode()) {
            throw new \Exception('Video type not supported!');
        }

        return array(
            'url'         => $info->getUrl(),
            'player'      => $info->getCode(),
            'title'       => $info->getTitle(),
            'description' => $info->getDescription(),
            'thumbnail'   => $info->getImage(),
        );
    }

    private function getAdapter($data)
    {
        foreach (new \DirectoryIterator(__DIR__ . '/Adapter') as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }

            $filename = pathinfo($fileInfo->getFilename(), PATHINFO_FILENAME);
            $class = '\\ThePhpFactory\\Wall\\Media\\Video\\Adapter\\' . $filename;

            if (!class_exists($class)) {
                continue;
            }

            $rClass = new \ReflectionClass($class);

            if (!$rClass->implementsInterface('\\Embed\\Adapters\\AdapterInterface')) {
                continue;
            }

            $request = new Request($data, null, array());

            if (call_user_func(array($class, 'check'), $request)) {
                return $class;
            }
        }

        return null;
    }

    private function cacheThumbnail($thumbnail)
    {
        if (false === $this->cacheThumbnails) {
            return false;
        }

        $path = self::getCachePath($thumbnail);

        jimport('joomla.filesystem.file');

        if (\JFile::exists(JPATH_SITE . '/' . self::$cachePath . '/' . $path)) {
            return false;
        }

        $client = new Client(array('verify' => false));
        $contents = $client->get($thumbnail)->getBody()->getContents();

        \JFile::write(JPATH_SITE . '/' . self::$cachePath . '/' . $path, $contents);

        return true;
    }

    public function preview($data)
    {
        $media = $this->getInfo($data);

        return array(
            'render' => $this->renderMedia($media),
        );
    }

    public function renderMedia($media)
    {
        // Issue when upgrading from < 4.0.0 and video media does not have the embed player code.
        if (is_object($media) && !$media->player) {
            $data = $this->getInfo($media->url);

            $media->player = $data['player'];
            $media->thumbnail = $data['thumbnail'];

            /** @var \WallFactoryTableMediaVideo $video */
            $video = \WallFactoryTable::getInstance('MediaVideo');

            $video->save($media);
            $this->cacheThumbnail($video->thumbnail);
        }

        return parent::renderMedia($media);
    }
}
