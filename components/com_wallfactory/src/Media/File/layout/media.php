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

extract($displayData['media']);

$file = JUri::root() . 'media/com_wallfactory/storage/media/file/' . $path . '/' . $filename;

?>

<div class="post-media-photo">
    <?php if ($title || $description): ?>
        <div style="margin-bottom: 10px;">
            <b><?php echo $title; ?></b>

            <div>
                <?php echo nl2br($description); ?>
            </div>
        </div>
    <?php endif; ?>

    <a href="<?php echo $file; ?>" target="_blank" class="btn btn-small btn-success btn-sm">
        <span class="fa fa-fw fa-download"></span>&nbsp;<?php echo $filename; ?>
    </a>
</div>
