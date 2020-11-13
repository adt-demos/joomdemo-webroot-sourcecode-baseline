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

<?php if ($isMyProfile): ?>
    <div class="subscriptions-actions">
        <a href="<?php echo WallFactoryRoute::task('subscription.index'); ?>" class="btn btn-small btn-sm btn-secondary pull-right">
            <?php echo WallFactoryText::_('profile_subscriptions_button_manage'); ?>
        </a>
    </div>

<?php endif; ?>

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
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
