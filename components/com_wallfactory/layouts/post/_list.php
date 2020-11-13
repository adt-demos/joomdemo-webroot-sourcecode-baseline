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

<?php if (!$posts): ?>
    <p>
        <?php echo WallFactoryText::_('posts_no_posts_to_display'); ?>
    </p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <?php echo JHtmlWallFactory::renderLayout('post._post', array(
            'post'     => $post,
            'comments' => $comments,
        )); ?>
    <?php endforeach; ?>
<?php endif; ?>
