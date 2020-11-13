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

JHtml::stylesheet('media/com_wallfactory/assets/font-awesome/css/font-awesome.css');
JHtml::stylesheet('media/com_wallfactory/assets/frontend/stylesheet.css');

JHtml::script('media/com_wallfactory/assets/frontend/script.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/comments.js');

extract($displayData);

?>

<?php if (!$comment): ?>
    <h1><?php echo WallFactoryText::_('comment_show_not_found_title'); ?></h1>
    <p><?php echo WallFactoryText::_('comment_show_not_found_text'); ?></p>
<?php else: ?>
    <h1><?php echo WallFactoryText::sprintf('comment_show_title', $comment->id); ?></h1>

    <div class="wallfactory-view">
        <div class="comments posts">
            <?php echo JHtmlWallFactory::renderLayout('comment/_comment', array(
                'comment' => $comment,
            )); ?>
        </div>
    </div>
<?php endif; ?>

