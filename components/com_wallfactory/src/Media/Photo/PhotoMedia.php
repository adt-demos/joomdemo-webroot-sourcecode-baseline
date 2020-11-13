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

namespace ThePhpFactory\Wall\Media\Photo;

defined('_JEXEC') or die;

use Imagine\Gd\Imagine;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use ThePhpFactory\Wall\Media\MediaInterface;

class PhotoMedia extends MediaInterface
{
    private $basePath = null;
    private $tempPath = null;
    private $validExtensions = array('.png', '.jpg', '.jpeg', '.gif');

    public function submit($postId, $data)
    {
        /** @var \WallFactoryTableMediaPhoto $photo */
        $photo = \WallFactoryTable::getInstance('MediaPhoto');

        $photo->save(
            array('post_id' => $postId)
        );

        // Get folder.
        $folder = $photo->getFolder();

        // Get filename.
        $name = $this->slugifyName($data['upload']['name']);

        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        // Create folder.
        $this->createFolder($folder);

        // Move file.
        $filename = $this->moveFile($data['upload']['filename'], $folder, $name);

        // Create thumbnail.
        $thumbnail = $this->createThumbnail($folder, $name);

        $size = getimagesize($filename);
        $sizeThumbnail = getimagesize($thumbnail);
        $params = new Registry(array(
            'original'  => array(
                'width'  => $size[0],
                'height' => $size[1],
            ),
            'thumbnail' => array(
                'width'  => $sizeThumbnail[0],
                'height' => $sizeThumbnail[1],
            ),
        ));

        // Save photo.
        $photo->save(array(
            'title'       => $data['title'],
            'description' => $data['description'],
            'filename'    => $name,
            'path'        => $folder,
            'params'      => $params->toString(),
        ));

        return $photo->id;
    }

    private function slugifyName($name)
    {
        $name = str_replace('-', ' ', $name);
        $name = trim(strtolower($name));
        $name = preg_replace('/(\s|[^A-Za-z0-9\-\.])+/', '-', $name);
        $name = trim($name, '-');

        return $name;
    }

    private function createFolder($name)
    {
        \JFolder::create($this->getBasePath() . '/' . $name);
    }

    public function getBasePath()
    {
        if (null === $this->basePath) {
            $this->basePath = JPATH_SITE . '/media/com_wallfactory/storage/media/photo';
        }

        return $this->basePath;
    }

    private function moveFile($uploaded, $folder, $name)
    {
        $path = implode('/', array(
            substr($uploaded, 0, 2),
            substr($uploaded, 2, 2),
            substr($uploaded, 4),
        ));

        $src = $this->getTempPath() . '/' . $path;
        $dest = $this->getBasePath() . '/' . $folder . '/' . $name;

        \JFile::move($src, $dest);

        // Check if need to resize the photo.
        $configuration = $this->getConfiguration();

        $height = $configuration->get('height', 600);
        $width = $configuration->get('width', 800);

        $imagine = new Imagine();

        try {
            $image = $imagine->open($dest);
            $resize = false;

            if ($width < $image->getSize()->getWidth()) {
                $image->resize(
                    $image->getSize()->widen($width)
                );

                $resize = true;
            }

            if ($height < $image->getSize()->getHeight()) {
                $image->resize(
                    $image->getSize()->heighten($height)
                );

                $resize = true;
            }

            if ($resize) {
                $image->save($dest, array('jpeg_quality' => 100));
            }
        } catch (\Exception $e) {
        }

        return $dest;
    }

    public function getTempPath()
    {
        if (null === $this->tempPath) {
            $this->tempPath = JPATH_SITE . '/tmp/com_wallfactory/media/photo';
        }

        return $this->tempPath;
    }

    protected function getConfiguration()
    {
        $configuration = parent::getConfiguration();

        $configuration->set('valid_extensions', $this->validExtensions);

        return $configuration;
    }

    private function createThumbnail($folder, $name, $maxWidth = 400)
    {
        $imagine = new Imagine();
        $destination = $this->getBasePath() . '/' . $folder . '/thumbnail-' . $name;

        try {
            $image = $imagine->open($this->getBasePath() . '/' . $folder . '/' . $name);

            if ($maxWidth <= $image->getSize()->getWidth()) {
                $image->resize($image->getSize()->widen($maxWidth));
            }

            $image->save(
                $destination,
                array('jpeg_quality' => 100)
            );
        } catch (\Exception $e) {
        }

        return $destination;
    }

    public function preview($data)
    {
        jimport('joomla.filesystem.file');

        $name = md5($data['tmp_name']);

        if (false === @getimagesize($data['tmp_name'])) {
            throw new \Exception('This file is not a valid image!');
        }

        $extension = pathinfo($data['name'], PATHINFO_EXTENSION);

        $path = implode('/', array(
            substr($name, 0, 2),
            substr($name, 2, 2),
            substr($name, 4),
        ));

        $src = $data['tmp_name'];
        $dest = $this->getTempPath() . '/' . $path;

        File::upload($src, $dest);

        $orientation = new Orientation($dest);

        if ($orientation->degrees()) {
            $imagine = new Imagine();
            $imagine
                ->open($dest)
                ->rotate($orientation->degrees())
                ->save($dest . '.' . $extension);
            File::delete($dest);
            File::move($dest . '.' . $extension, $dest);
        }

        $output = [
            'filename'  => $name,
            'extension' => $extension,
            'name'      => $data['name'],
        ];

        if ($orientation) {
            $output['path'] = Uri::root() . 'tmp/com_wallfactory/media/photo/' . $path;
        }

        return $output;
    }
}
