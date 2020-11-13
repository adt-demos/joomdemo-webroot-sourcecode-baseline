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

JHtml::stylesheet('media/com_wallfactory/assets/frontend/stylesheet.css');

extract($displayData);

?>

<div class="wallfactory-view view-subscribers">
    <h1>
        <?php echo WallFactoryText::_('subscribers_page_title'); ?>
    </h1>

    <?php if (!$subscribers): ?>
        <p><?php echo WallFactoryText::_('subscribers_no_results_found'); ?></p>
    <?php else: ?>
        <table class="table table-striped">
            <tbody>
            <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                    <td>
                        <div class="user">
                            <?php echo JHtmlWallFactory::profileAvatar($subscriber); ?>
                        </div>
                    </td>

                    <td>
                        <a href="<?php echo WallFactoryRoute::task('profile.show&id=' . $subscriber->subscriber_id); ?>"
                           class="username">
                            <b><?php echo $subscriber->name; ?></b>
                        </a>

                        <div class="small muted text-muted">
                            <?php echo JHtml::_('date', $subscriber->created_at, 'd F Y, H:i'); ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
