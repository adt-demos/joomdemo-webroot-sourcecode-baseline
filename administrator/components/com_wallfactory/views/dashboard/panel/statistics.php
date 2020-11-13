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
$model = JModelLegacy::getInstance('Posts', 'WallFactoryBackendModel', [
    'ignore_request' => true,
]);
$posts = $model->getTotal();

/** @var WallFactoryBackendModelComments $model */
$model = JModelLegacy::getInstance('Comments', 'WallFactoryBackendModel', [
    'ignore_request' => true,
]);
$comments = $model->getTotal();

/** @var WallFactoryBackendModelUsers $model */
$model = JModelLegacy::getInstance('Users', 'WallFactoryBackendModel', [
    'ignore_request' => true,
]);
$users = $model->getTotal();

/** @var WallFactoryBackendModelSubscriptions $model */
$model = JModelLegacy::getInstance('Subscriptions', 'WallFactoryBackendModel', [
    'ignore_request' => true,
]);
$subscriptions = $model->getTotal();

/** @var WallFactoryBackendModelReports $model */
$model = JModelLegacy::getInstance('Reports', 'WallFactoryBackendModel', [
    'ignore_request' => true,
]);
$reports = $model->getTotal();

/** @var WallFactoryBackendModelMedia $model */
$repoMedia = JModelLegacy::getInstance('Media', 'WallFactoryBackendModel', [
    'ignore_request' => true,
]);

?>

<table class="table table-striped">
    <tbody>
    <tr>
        <td style="width: 50%; border-top: none;">
            <a href="<?php echo WallFactoryRoute::view('posts'); ?>">
                <b>Posts</b>
            </a>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($posts); ?>
            </div>
        </td>

        <td style="width: 50%; border-top: none;">
            <b>Links</b>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($repoMedia->count('Link')); ?>
            </div>
        </td>
    </tr>

    <tr>
        <td style="width: 50%;">
            <a href="<?php echo WallFactoryRoute::view('comments'); ?>">
                <b>Comments</b>
            </a>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($comments); ?>
            </div>
        </td>

        <td style="width: 50%;">
            <b>Videos</b>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($repoMedia->count('Video')); ?>
            </div>
        </td>
    </tr>

    <tr>
        <td style="width: 50%;">
            <a href="<?php echo WallFactoryRoute::view('users'); ?>">
                <b>Users</b>
            </a>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($users); ?>
            </div>
        </td>

        <td style="width: 50%;">
            <b>Photos</b>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($repoMedia->count('Photo')); ?>
            </div>
        </td>
    </tr>

    <tr>
        <td style="width: 50%;">
            <a href="<?php echo WallFactoryRoute::view('reports'); ?>">
                <b>Reports</b>
            </a>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($reports); ?>
            </div>
        </td>

        <td style="width: 50%;">
            <b>Documents</b>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($repoMedia->count('File')); ?>
            </div>
        </td>
    </tr>

    <tr>
        <td style="width: 50%;">
            <b>Subscriptions</b>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($subscriptions); ?>
            </div>
        </td>

        <td style="width: 50%;">
            <b>Audio files</b>
            <div class="pull-right" style="padding-right: 10px;">
                <?php echo JHtmlWallFactory::badgeNumber($repoMedia->count('Audio')); ?>
            </div>
        </td>
    </tr>
    </tbody>
</table>
