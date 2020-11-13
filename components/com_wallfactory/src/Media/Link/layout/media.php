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

?>

<div class="post-media-link">
    <a href="<?php echo $url; ?>" target="_blank">
        <b><?php echo $title; ?></b>
    </a>

    <div style="margin: 5px 0 5px;">
        <?php echo $description; ?>
    </div>

    <a href="<?php echo $url; ?>" target="_blank" class="muted text-muted">
        <?php echo $url; ?>
    </a>
</div>
