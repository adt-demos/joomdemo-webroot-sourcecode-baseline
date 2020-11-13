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

<div><!--
    <?php foreach ($emoticons

    as $emoticon): ?>
        --><a href="#" data-emoji="<?php echo htmlentities(json_encode($emoticon)); ?>"><!--
            --><img
                src="<?php echo JUri::root(); ?>media/com_wallfactory/storage/emoticons/<?php echo $emoticon->filename; ?>"><!--
        --></a><!--
    <?php endforeach; ?>
--></div>
