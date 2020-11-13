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

extract($displayData); ?>

<div class="bookmarks">
    <?php foreach ($bookmarks as $bookmark): ?>
        <a href="<?php echo $bookmark->link; ?>" target="_blank"
           title="<?php echo WallFactoryText::sprintf('share_using', $bookmark->title); ?>"><img
                    src="<?php echo JHtml::_('WallFactoryBookmark.src', $bookmark->thumbnail); ?>"/></a>
    <?php endforeach; ?>
</div>
