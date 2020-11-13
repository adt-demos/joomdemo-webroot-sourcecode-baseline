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

use Joomla\CMS\HTML\HTMLHelper;

extract($displayData['media']);

$configuration = $displayData['configuration'];
$lazyLoad = $configuration->get('lazyload', 1);

$file = JUri::root() . 'media/com_wallfactory/storage/media/photo/' . $path . '/' . $filename;
$thumbnail = JUri::root() . 'media/com_wallfactory/storage/media/photo/' . $path . '/thumbnail-' . $filename;

if ($lazyLoad) {
    $params = new \Joomla\Registry\Registry($params);
    $height = $params->get('thumbnail.height');
    $width = $params->get('thumbnail.width');
    HTMLHelper::script('media/com_wallfactory/assets/frontend/jquery.lazyloadxt.min.js');
}

?>

<div class="post-media-photo">
    <a href="<?php echo $file; ?>" target="_blank">
        <?php if ($lazyLoad): ?>
            <img src="<?php echo JUri::root(); ?>media/com_wallfactory/assets/images/blank.gif"
                 data-src="<?php echo $thumbnail; ?>"
                 style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>px;"/>
        <?php else: ?>
            <img src="<?php echo $thumbnail; ?>"/>
        <?php endif; ?>
    </a>

    <div style="margin-top: 5px;">
        <a href="<?php echo $file; ?>">
            <?php echo $title; ?>
        </a>

        <div>
            <?php echo nl2br($description); ?>
        </div>
    </div>
</div>
