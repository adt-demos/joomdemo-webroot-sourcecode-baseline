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
JHtml::script('media/com_wallfactory/assets/plugins/jquery.mark.min.js');
JHtml::script('media/com_wallfactory/assets/frontend/script.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/search.js');

extract($displayData);

?>

<div class="wallfactory-view view-search" data-query="<?php echo $query; ?>">
    <h1>Search posts</h1>

    <?php echo JHtmlWallFactory::renderLayout('post.index', array(
        'dataUrl'    => '',
        'posts'      => $posts,
        'pagination' => $pagination,
        'comments'   => $comments,
    )); ?>
</div>
