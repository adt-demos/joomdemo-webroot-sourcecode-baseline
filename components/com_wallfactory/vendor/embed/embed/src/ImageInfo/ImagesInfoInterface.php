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

namespace Embed\ImageInfo;

defined('_JEXEC') or die;

/**
 * Inteface used by all imageinfo interfaces.
 */
interface ImagesInfoInterface
{
    /**
     * Get the info of multiple images at once.
     *
     * @param array      $urls
     * @param null|array $config
     *
     * @return array
     */
    public static function getImagesInfo(array $urls, array $config = null);
}
