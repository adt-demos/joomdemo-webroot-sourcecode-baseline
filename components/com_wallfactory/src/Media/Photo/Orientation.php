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

class Orientation
{
    private $path;
    private $degrees = null;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function degrees()
    {
        if (null === $this->degrees) {
            $this->degrees = $this->calculate();
        }

        return $this->degrees;
    }

    private function calculate()
    {
        if (!function_exists('exif_read_data')) {
            return 0;
        }

        $exifData = @exif_read_data($this->path);

        if (false === $exifData) {
            return 0;
        }

        if (!isset($exifData['Orientation'])) {
            return 0;
        }

        switch ($exifData['Orientation']) {
            case 8:
                return -90;
            case 3:
                return 180;
            case 6:
                return 90;
        }

        return 0;
    }
}

