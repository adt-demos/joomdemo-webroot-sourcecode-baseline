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

/** @var WallFactoryBackendModelReports $model */
$model = JModelLegacy::getInstance('Reports', 'WallFactoryBackendModel', [
    'ignore_request' => true,
    'state'          => new JObject([
        'list.limit' => 5,
    ]),
]);

$results = $model->getItems();

?>

<style>
    div.dashboard table.table span.label {
        font-size: 10px;
        line-height: normal;
        padding: 0 5px 2px;
        text-transform: lowercase;
    }
</style>

<?php if ($results): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th colspan="2">Report</th>
            <th class="thinnest">Status</th>
            <th width="140px">Date</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($results as $item): ?>
            <tr>
                <td class="thinnest">
                    <a href="<?php echo WallFactoryRoute::task('report.edit&id=' . $item->id); ?>"
                       class="btn btn-mini btn-sm"><span
                                class="fa fa-fw fa-pencil"></span></a>
                </td>

                <td>
                    <?php echo JHtml::_('string.truncate', $item->comment, 150, true, false); ?>
                </td>

                <td>
                    <?php echo JHtml::_('WallFactory.reportStatus', $item->resolved); ?>
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
        <?php echo WallFactoryText::_('dashboard_panel_report_latest_no_results'); ?>
    </div>
<?php endif; ?>

<div class="actions">
    <a href="<?php echo WallFactoryRoute::view('reports&reset=1&filter[resolved]=0'); ?>">
        <?php echo WallFactoryText::_('dashboard_panel_report_latest_link_unresolved_reports'); ?></a>

    <a href="<?php echo WallFactoryRoute::view('reports&reset=1'); ?>">
        <?php echo WallFactoryText::_('dashboard_panel_report_latest_link_all_reports'); ?>
    </a>
</div>

