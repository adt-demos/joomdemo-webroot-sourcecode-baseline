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

namespace ThePhpFactory\Wall\Media\File;

defined('_JEXEC') or die;

use ThePhpFactory\Wall\Media\MediaInterface;

class FileMedia extends MediaInterface
{
    private $basePath = null;
    private $tempPath = null;
    private $validExtensions = null;

    public function submit($postId, $data)
    {
        /** @var \WallFactoryTableMediaFile $file */
        $file = \WallFactoryTable::getInstance('MediaFile');

        $file->save(
            array('post_id' => $postId)
        );

        // Get folder.
        $folder = $file->getFolder();

        // Get filename.
        $name = $this->slugifyName($data['upload']['name']);

        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        // Create folder.
        $this->createFolder($folder);

        // Move file.
        $this->moveFile($data['upload']['filename'], $folder, $name);

        // Save file.
        $file->save(array(
            'title'       => $data['title'],
            'description' => $data['description'],
            'filename'    => $name,
            'path'        => $folder,
        ));

        return $file->id;
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
            $this->basePath = JPATH_SITE . '/media/com_wallfactory/storage/media/file';
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
    }

    public function getTempPath()
    {
        if (null === $this->tempPath) {
            $this->tempPath = JPATH_SITE . '/tmp/com_wallfactory/media/file';
        }

        return $this->tempPath;
    }

    public function preview($data)
    {
        jimport('joomla.filesystem.file');

        $name = md5($data['tmp_name']);
        $extension = pathinfo($data['name'], PATHINFO_EXTENSION);

        $this->assertValidExtension('.' . $extension);

        $path = implode('/', array(
            substr($name, 0, 2),
            substr($name, 2, 2),
            substr($name, 4),
        ));

        $src = $data['tmp_name'];
        $dest = $this->getTempPath() . '/' . $path;

        \JFile::upload($src, $dest);

        return array(
            'filename'  => $name,
            'extension' => $extension,
            'name'      => $data['name'],
        );
    }

    private function assertValidExtension($extension)
    {
        if (!in_array(strtolower($extension), $this->getValidExtensions())) {
            throw new \Exception(sprintf(
                'This file is not a valid document file! Valid document file extensions: %s',
                implode(', ', $this->getValidExtensions())
            ));
        }
    }

    public function getValidExtensions()
    {
        if (null === $this->validExtensions) {
            $extensions = str_replace(' ', '', $this->options->get('extensions'));

            if ('' === $extensions) {
                $this->validExtensions = array();
            }
            else {
                $this->validExtensions = explode(',', $extensions);
            }
        }

        return $this->validExtensions;
    }

    protected function getConfiguration()
    {
        $configuration = parent::getConfiguration();

        $configuration->set('valid_extensions', $this->getValidExtensions());

        return $configuration;
    }
}
