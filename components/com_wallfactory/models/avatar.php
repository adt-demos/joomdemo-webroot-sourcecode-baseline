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

use Imagine\Gd\Image;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use ThePhpFactory\Wall\Media\Photo\Orientation;

class WallFactoryFrontendModelAvatar extends JModelLegacy
{
    private $basePath = '/media/com_wallfactory/storage/avatars';
    private $size = 120;

    public function upload($userId, $file)
    {
        if (!\WallFactoryAvatar::canUploadAvatar()) {
            throw new \Exception('Forbidden', 403);
        }

        // Check if upload was successful.
        $this->assertValidUpload($file);

        // Load profile.
        $profile = WallFactoryTable::getInstance('Profile');
        $profile->load($userId);

        // Remove old thumbnail avatar.
        if ('thumbnail' === $profile->avatar_source) {
            $this->removeAvatar($profile->thumbnail);
        }

        // Open uploaded image.
        $imagine = new Imagine();
        $image = $imagine->open($file['tmp_name']);
        $orientation = new Orientation($file['tmp_name']);

        // Resize and crop image.
        $this->resize($image, $orientation);

        // Save image.
        $filename = $this->save($image, $file, $userId);

        // Update profile.
        $this->updateProfile($profile, $filename);

        return JUri::root() . $this->basePath . '/' . $profile->thumbnail;
    }

    private function assertValidUpload($file)
    {
        if (!is_array($file) || !isset($file['error'])) {
            throw new Exception('No file uploaded!');
        }

        if ($file['error']) {
            throw new Exception(sprintf('Upload error %d!', $file['error']));
        }
    }

    private function removeAvatar($thumbnail)
    {
        if ('' === $thumbnail) {
            return true;
        }

        $file = JPATH_SITE . $this->basePath . '/' . $thumbnail;

        jimport('joomla.filesystem.file');

        if (!JFile::exists($file)) {
            return true;
        }

        return JFile::delete($file);
    }

    private function resize(Image $image, Orientation $orientation)
    {
        if ($orientation->degrees()) {
            $image->rotate($orientation->degrees());
        }

        $size = $image->getSize();

        if ($size->getHeight() > $size->getWidth()) {
            $image->resize($size->widen($this->size));

            $point = new Point(0, ($image->getSize()->getHeight() - $this->size) / 2);
        }
        else {
            $image->resize($size->heighten($this->size));

            $point = new Point(($image->getSize()->getWidth() - $this->size) / 2, 0);
        }

        $image->crop($point, new Box($this->size, $this->size));
    }

    private function save(Image $image, $file, $userId)
    {
        jimport('joomla.filesystem.folder');

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'thumbnail.' . $extension;

        $userPath = $this->getFullPath($userId);

        JFolder::exists($userPath) or JFolder::create($userPath);

        $image->save($userPath . '/' . $filename, array(
            'jpeg_quality' => 100,
        ));

        return $filename;
    }

    public function getFullPath($id)
    {
        $path = $this->getRelativePath($id);

        return JPATH_SITE . $this->basePath . '/' . $path;
    }

    public function getRelativePath($id)
    {
        $padded = str_pad($id, 12, 0, STR_PAD_LEFT);
        $split = str_split($padded, 3);

        return implode('/', $split);
    }

    private function updateProfile(WallFactoryTableProfile $profile, $filename)
    {
        $profile->save(array(
            'avatar_source' => 'thumbnail',
            'thumbnail'     => $this->getRelativePath($profile->user_id) . '/' . $filename,
        ));
    }
}
