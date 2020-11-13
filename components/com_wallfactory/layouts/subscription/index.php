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

<div class="wallfactory-view view-subscriptions">
    <h1>
        <?php echo WallFactoryText::_('subscriptions_page_title'); ?>
    </h1>

    <?php if (!$subscriptions): ?>
        <p><?php echo WallFactoryText::_('subscriptions_no_results_found'); ?></p>
    <?php else: ?>
        <table class="table table-striped">
            <tbody>
            <?php foreach ($subscriptions as $subscription): ?>
                <tr>
                    <td class="avatar">
                        <?php echo JHtmlWallFactory::profileAvatar($subscription); ?>
                    </td>

                    <td>
                        <a href="<?php echo WallFactoryRoute::task('profile.show&id=' . $subscription->user_id); ?>"
                           class="username">
                            <b><?php echo $subscription->name; ?></b>
                        </a>

                        <div class="muted text-muted small">
                            <?php echo JHtml::_('date', $subscription->created_at, 'd F Y, H:i'); ?>
                        </div>
                    </td>

                    <td class="notification">
                        <?php echo JHtmlWallFactory::subscriptionNotification($subscription->notification, $subscription->user_id); ?>
                    </td>

                    <td class="status">
                        <a href="<?php echo WallFactoryRoute::task('subscription.cancel&format=raw&user_id=' . $subscription->user_id); ?>"
                           class="btn btn-small btn-sm">
                            <?php echo WallFactoryText::_('subscription_button_cancel'); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
