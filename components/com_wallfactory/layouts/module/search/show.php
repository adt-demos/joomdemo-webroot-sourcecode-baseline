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

extract($displayData);

$url = WallFactoryRoute::task('post.search');
$uri = new JUri($url);

?>

<form action="<?php echo $url; ?>" method="get" class="form-search">
    <input type="text" value="<?php echo $query; ?>" name="query" class="input-medium search-query"/>
    <button type="submit" class="btn btn-primary mt-2">
        <?php echo WallFactoryText::_('module_search_button_label'); ?>
    </button>

    <?php foreach ($uri->getQuery(true) as $name => $value): ?>
        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/>
    <?php endforeach; ?>
</form>
