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

/** @var WallFactoryBackendModelPosts $model */
$model = JModelLegacy::getInstance('Posts', 'WallFactoryBackendModel', array(
    'ignore_request' => true,
    'state'          => new JObject(array(
        'list.limit' => 5,
    )),
));

$results = $model->getItems();

?>

<?php if ($results): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th colspan="2">Content</th>
            <th width="140px">Date</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($results as $item): ?>
            <tr>
                <td class="thinnest">
                    <a href="<?php echo WallFactoryRoute::task('post.edit&id=' . $item->id); ?>"
                       class="btn btn-mini btn-sm"><span class="fa fa-fw fa-pencil"></span></a>
                </td>

                <td>
                    <?php echo JHtml::_('WallFactory.content', $item->content); ?>
                </td>

                <td class="nowrap muted text-muted">
                    <?php echo JHtml::_('date', $item->created_at, 'COM_WALLFACTORY_DASHBOARD_FORMAT_DATE'); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (!$results): ?>
    <div class="no-results">
        <?php echo WallFactoryText::_('dashboard_panel_post_latest_no_results'); ?>
    </div>
<?php endif; ?>

<div class="actions">
    <a href="<?php echo WallFactoryRoute::view('posts&reset=1'); ?>">
        <?php echo WallFactoryText::_('dashboard_panel_posts_latest_link_all_posts'); ?>
    </a>
</div>

