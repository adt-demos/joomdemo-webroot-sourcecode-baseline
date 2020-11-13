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

JHtml::_('jQuery.framework');
JHtml::script('media/com_wallfactory/assets/frontend/script.js');

extract($displayData);

?>

<div class="wallfactory-view">
    <h1><?php echo WallFactoryText::_('post_all_heading'); ?></h1>

    <?php echo JHtmlWallFactory::renderTask('post.form', array(
        'userId' => $toProfile ? $toProfile->user_id : 0,
    )); ?>

    <?php echo JHtmlWallFactory::renderTask('wall.posts', array(
        'userId'     => 0,
        'comments'   => $comments,
        'limitstart' => $limitstart,
    )); ?>
</div>
