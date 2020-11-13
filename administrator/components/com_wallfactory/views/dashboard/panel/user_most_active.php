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

/** @var WallFactoryBackendModelUsers $model */
$model = JModelLegacy::getInstance('Users', 'WallFactoryBackendModel', [
    'ignore_request' => true,
    'state'          => new JObject([
        'list.limit'     => 5,
        'list.ordering'  => 'posts',
        'list.direction' => 'desc',
        'list.has_posts' => 1,
    ]),
]);

$results = $model->getItems();

?>

<?php if ($results): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th colspan="2">User</th>
            <th class="thinnest center">Posts</th>
            <th width="140px">Last Post</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($results as $item): ?>
            <tr>
                <td style="width: 40px;">
                    <?php echo JHtmlWallFactory::profileAvatar($item); ?>
                </td>
                <td>
                    <a href="<?php echo WallFactoryRoute::task('user.edit&id=' . $item->user_id); ?>">
                        <?php echo $item->name; ?>
                    </a>
                    <div class="small muted">
                        <?php echo $item->username; ?>
                    </div>
                </td>

                <td class="nowrap muted text-muted center">
                    <span class="badge badge-success"><?php echo $item->posts; ?></span>
                </td>

                <td class="nowrap muted text-muted">
                    <?php echo JHtml::_('date', $item->last_post_at, 'COM_WALLFACTORY_DASHBOARD_FORMAT_DATE'); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (!$results): ?>
    <div class="no-results">
        <?php echo WallFactoryText::_('dashboard_panel_user_most_active_no_results'); ?>
    </div>
<?php endif; ?>

<div class="actions">
    <a href="<?php echo WallFactoryRoute::view('users&reset=1'); ?>">
        <?php echo WallFactoryText::_('dashboard_panel_user_most_active_link_all_posts'); ?>
    </a>
</div>

