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

JHtml::script('media/com_wallfactory/assets/frontend/script.js');

JHtml::script('media/com_wallfactory/assets/plugins/handlebars.js');
JHtml::script('media/com_wallfactory/assets/autosize/autosize.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/submitpost.js');

JHtml::_('bootstrap.tooltip');
JHtml::script('media/com_wallfactory/assets/liked/liked.js');
JHtml::script('media/com_wallfactory/assets/report/report.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/bookmark.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/comment.js');
JHtml::script('media/com_wallfactory/assets/frontend/js/comments.js');

if ($emoticons) {
    JHtml::stylesheet('media/com_wallfactory/assets/emojiarea/jquery.emojiarea.css');
    JHtml::script('media/com_wallfactory/assets/emojiarea/jquery.emojiarea.js');

    JHtml::stylesheet('media/com_wallfactory/assets/webui-popover/jquery.webui-popover.css');
    JHtml::script('media/com_wallfactory/assets/webui-popover/jquery.webui-popover.js');
    JFactory::getDocument()->addScriptDeclaration('var base_url = "' . JUri::root() . '";');
}
?>

<div class="submit-post">
    <div class="submit-post-user">
        <?php echo JHtmlWallFactory::profileAvatar($profile); ?>
    </div>

    <div class="submit-post-contents">
        <form action="<?php echo WallFactoryRoute::raw('post.submit'); ?>" method="post"
              data-captcha="<?php echo htmlentities($form->renderField('captcha')); ?>">
            <input type="hidden" name="post[to_user_id]" value="<?php echo $toUserId; ?>">

            <?php echo $form->getField('content')->input; ?>

            <div class="submit-post-buttons" style="display: none;"
                 data-config="<?php echo htmlentities(json_encode($config)); ?>">
                <script id="media-button-template" type="text/x-handlebars-template">
                    <button type="button" class="hasTooltip" title="{{tooltip}}" data-media-button="{{type}}" id="media_{{type}}">
                        <span class="fa fa-fw {{icon}}"></span>
                    </button>
                </script>

                <?php foreach ($mediaTypes as $media): ?>
                    <?php echo $media->renderUpload(); ?>
                <?php endforeach; ?>
            </div>

            <div class="submit-post-actions" style="display: none;">
                <?php echo $form->renderFieldset('guest'); ?>

                <button class="btn btn-small btn-sm btn-success" type="button" data-action="submit">
                    <?php echo WallFactoryText::_('post_button_submit_post'); ?>
                </button>

                <a href="#" class="btn btn-small btn-sm btn-link" data-action="cancel">
                    <?php echo WallFactoryText::_('post_button_cancel'); ?>
                </a>
            </div>

            <div class="submit-post-media"></div>
        </form>
    </div>
</div>
