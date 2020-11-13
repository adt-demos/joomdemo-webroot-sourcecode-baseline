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

use Joomla\CMS\Component\ComponentHelper;

class JHtmlWallFactory
{
    public static function username($username = null, $name = null, $anonymous = true)
    {
        if ('' !== (string)$name) {
            return $name;
        }

        if ('' !== (string)$username) {
            return $username;
        }

        if ($anonymous) {
            return WallFactoryText::_('username_anonymous');
        }

        return WallFactoryText::_('username_not_found');
    }

    public static function badgeNumberSuccess($number, $url = null)
    {
        return self::badgeNumber($number, $url, 'success');
    }

    public static function badgeNumber($number, $url = null, $badge = null)
    {
        if (!(int)$number) {
            return '<span class="muted text-muted">&mdash;</span>';
        }

        if (null !== $badge) {
            $badge = 'badge-' . $badge;
        }

        $number = number_format($number, 0);

        if (null !== $url) {
            return '<a href="' . $url . '" class="badge badge-pill badge-secondary' . $badge . '">' . $number . '</a>';
        }

        return '<span class="badge ' . $badge . ' badge-pill badge-secondary">' . $number . '</span>';
    }

    public static function description($description, $length = 100)
    {
        if ('' === (string)$description) {
            return WallFactoryText::_('no_description');
        }

        return JHtml::_('string.truncate', $description, $length, true, false);
    }

    public static function postTitle($content, $id, $length = 25)
    {
        return WallFactoryText::sprintf(
            'post_title',
            JHtml::_('string.truncate', $content, $length, true, false),
            $id
        );
    }

    public static function reportStatus($resolved)
    {
        if ($resolved) {
            return '<span class="label label-success">' . WallFactoryText::_('report_status_resolved') . '</span>';
        }

        return '<span class="label label-important">' . WallFactoryText::_('report_status_unresolved') . '</span>';
    }

    public static function content($string)
    {
        $string = self::nl2p($string);
        $string = self::convertEmoticons($string);

        return $string;
    }

    public static function nl2p($string)
    {
        return '<p>' . preg_replace('#(<br\s*?/?>\s*?){2,}#', '</p>' . "\n" . '<p>', nl2br($string)) . '</p>';
    }

    private static function convertEmoticons($string)
    {
        static $emoticons = null;
        static $enabled = null;

        if (null === $enabled) {
            $params = JComponentHelper::getParams('com_wallfactory');
            $enabled = $params->get('posting.emoticons.enabled', 1);
        }

        if ($enabled && null === $emoticons) {
            $model = new WallFactoryFrontendModelEmoticons();
            $emoticons = $model->fetchAll();
        }

        if (!$enabled) {
            $string = preg_replace('/::([0-9]+)::/', '', $string);
        }
        else {
            if (preg_match_all('/::([0-9]+)::/', $string, $matches)) {
                $search = $matches[0];
                $replace = [];

                foreach ($matches[1] as $match) {
                    if (!isset($emoticons[$match])) {
                        $replace[] = '';
                    }
                    else {
                        $replace[] = '<img class="emoticon" src="' . JUri::root() . 'media/com_wallfactory/storage/emoticons/' . $emoticons[$match]['filename'] . '" alt="' . $emoticons[$match]['title'] . '" title="' . $emoticons[$match]['title'] . '" />';
                    }

                }

                $string = str_replace($search, $replace, $string);
            }
        }

        return $string;
    }

    public static function report($type, $id)
    {
        JHtml::_('jQuery.framework');
//        JHtml::_('bootstrap.modal');

        JHtml::script('media/com_wallfactory/assets/autosize/autosize.js');
        JHtml::script('media/com_wallfactory/assets/report/report.js');

        $url = WallFactoryRoute::raw('report.form&type=' . $type . '&id=' . $id);

        return '<a href="' . $url . '" data-report="true" class="dropdown-item">' . WallFactoryText::_('report_button_label') . '</a>';
    }

    public static function likes($likes, $resourceType, $resourceId)
    {
        $config = JComponentHelper::getParams('com_wallfactory');

        if (!$config->get('like.enabled', 1)) {
            return null;
        }

        JHtml::_('bootstrap.tooltip');
        JHtml::script('media/com_wallfactory/assets/liked/liked.js');

        $class = $likes ? 'badge-success' : '';
        $text = WallFactoryText::plural('likes_display_likes', $likes);
        $url = WallFactoryRoute::raw('like.index&type=' . $resourceType . '&id=' . $resourceId);

        return '<a id="likes-' . $resourceType. '-' . $resourceId . '" href="' . $url . '" data-likes="' . $resourceType . '" data-id="' . $resourceId . '"><span class="badge badge-pill badge-secondary ' . $class . '">' . $text . '</span></a>';
    }

    public static function like($liked, $resourceType, $resourceId)
    {
        $config = JComponentHelper::getParams('com_wallfactory');

        if (JFactory::getUser()->guest) {
            return null;
        }

        if (!$config->get('like.enabled', 1)) {
            return null;
        }

        JHtml::_('bootstrap.tooltip');
        JHtml::script('media/com_wallfactory/assets/liked/liked.js');

        if ($liked) {
            $url = WallFactoryRoute::raw('like.remove&type=' . $resourceType . '&id=' . $resourceId);
            $text = WallFactoryText::_('like_button_unlike');

            return '<a id="unlike-' . $resourceType. '-' . $resourceId . '" href="' . $url . '" data-like="remove">' . $text . '</a>';
        }

        $url = WallFactoryRoute::raw('like.submit&type=' . $resourceType . '&id=' . $resourceId);
        $text = WallFactoryText::_('like_button_like');

        return '<a id="like-' . $resourceType. '-' . $resourceId . '" href="' . $url . '" data-like="submit">' . $text . '</a>';
    }

    public static function bookmark($postId)
    {
        $config = JComponentHelper::getParams('com_wallfactory');

        if (!$config->get('bookmark.enabled', 1)) {
            return null;
        }

        JHtml::script('media/com_wallfactory/assets/frontend/js/bookmark.js');

        $text = WallFactoryText::_('share_button_share');
        $url = WallFactoryRoute::raw('bookmark.index&post_id=' . $postId);

        return '<a href="' . $url . '" class="muted text-muted" data-action="bookmark">' . $text . '</a>';
    }

    public static function comment($postId)
    {
        $config = JComponentHelper::getParams('com_wallfactory');

        if (!$config->get('comment.enabled', 1)) {
            return false;
        }

        if (JFactory::getUser()->guest && !$config->get('comment.guest', 0)) {
            return false;
        }

        JHtml::script('media/com_wallfactory/assets/autosize/autosize.js');
        JHtml::script('media/com_wallfactory/assets/frontend/js/comment.js');

        if (JFactory::getUser()->guest && $config->get('comment.captcha', 0)) {
            $file = 'https://www.google.com/recaptcha/api.js?render=explicit&hl=' . JFactory::getLanguage()->getTag();
            JHtml::_('script', $file);
        }

        $text = WallFactoryText::_('comment_button_comment');
        $url = WallFactoryRoute::raw('comment.form&post_id=' . $postId);

        return '<a id="comment-' . $postId . '" href="' . $url . '" class="muted text-muted" data-comment="' . $postId . '">' . $text . '</a>';
    }

    public static function profileAvatar($profile)
    {
        $configuration = ComponentHelper::getParams('com_wallfactory');
        $src = JUri::root() . 'media/com_wallfactory/assets/images/user.png';

        if (!isset($profile->avatar_source)) {
            return '<img src="' . $src . '" class="avatar" />';
        }

        $profileAvatarSource = $profile->avatar_source;

        if (!WallFactoryAvatar::canChangeAvatarSource($profile->user_id)) {
            $profileAvatarSource = WallFactoryAvatar::configurationAvatarSource();
        }

        switch ($profileAvatarSource) {
            case 'thumbnail':
                if ($profile->thumbnail) {
                    $src = JUri::root() . 'media/com_wallfactory/storage/avatars/' . $profile->thumbnail;
                }
                break;

            case 'gravatar':
                if ($configuration->get('integrations.gravatar.profile', 0)) {
                    $src = 'https://www.gravatar.com/avatar/' . $profile->thumbnail . '?s=120';
                }
                break;

            case 'community_builder':
                $cb = \ThePhpFactory\Wall\Integration\CommunityBuilder\CommunityBuilder::getInstance($configuration);
                if ($cb->isAvatarIntegrationEnabled() && $source = $cb->getAvatarIntegrationSource($profile->user_id)) {
                    $src = $source;
                }
                break;
        }

        return '<img src="' . $src . '" class="avatar" />';
    }

    public static function guestAvatar($guest)
    {
        $src = 'media/com_wallfactory/assets/images/user.png';

        $configuration = JComponentHelper::getParams('com_wallfactory');

        if ($configuration->get('integrations.gravatar.guest', 0) && isset($guest->author_email)) {
            $hash = md5(strtolower(trim($guest->author_email)));
            $src = 'https://www.gravatar.com/avatar/' . $hash . '?s=120';
        }

        return '<img src="' . $src . '" class="avatar" />';
    }

    public static function subscribe($subscribed, $userId)
    {
        if (!$userId) {
            return null;
        }

        $config = JComponentHelper::getParams('com_wallfactory');
        $user = JFactory::getUser();

        if ($user->guest || !$config->get('subscription.enabled', 1)) {
            return null;
        }

        JHtml::_('bootstrap.tooltip');
        JHtml::script('media/com_wallfactory/assets/frontend/js/subscription.js');

        if ($subscribed) {
            $url = WallFactoryRoute::raw('subscription.cancel&user_id=' . $userId);
            $text = WallFactoryText::_('subscribe_button_unsubscribe');

            return '<a href="' . $url . '" data-subscribe="' . $userId . '">' . $text . '</a>';
        }

        $url = WallFactoryRoute::raw('subscription.register&user_id=' . $userId);
        $text = WallFactoryText::_('subscribe_button_subscribe');

        return '<a href="' . $url . '" data-subscribe="' . $userId . '">' . $text . '</a>';
    }

    public static function subscriptionNotification($notification, $userId)
    {
        $url = WallFactoryRoute::task('subscription.notification&user_id=' . $userId);

        $html[] = '<a href="' . $url . '" data-subscription="notification" class="btn btn-small btn-sm ' . (!$notification ? 'btn-danger' : 'btn-success') . '">';
        $html[] = '<span class="fa fa-fw fa-bell' . (!$notification ? '-slash' : '') . '"></span>';
        $html[] = '</a>';

        return implode($html);
    }

    public static function mediaVideoThumbnail($thumbnail, $player, $lazyLoad = 'view')
    {
        $html = [];

        $html[] = '<div class="thumbnail-wrapper" data-lazy-video="' . htmlentities($player) . '" data-lazy-load="' . $lazyLoad . '">';

        if ($thumbnail) {
            $cached = \ThePhpFactory\Wall\Media\Video\VideoMedia::getCachedPath($thumbnail);
            $src = false !== $cached ? $cached : $thumbnail;

            $html[] = '<img src="' . $src . '" />';
        }

        $html[] = '<span class="fa fa-fw fa-play-circle"></span>';
        $html[] = '</div>';

        return implode("\n", $html);
    }

    public static function renderTask($task, array $parameters = [])
    {
        $configuration = JComponentHelper::getParams('com_wallfactory');
        $input = new JInput($parameters);

        $input->set('task', $task);

        return WallFactoryApp::render($input, $configuration);
    }

    public static function renderLayout($layout, array $displayData = [])
    {
        $layout = new JLayoutFile($layout, null, [
            'component' => 'com_wallfactory',
        ]);

        $displayData['juser'] = JFactory::getUser();

        return $layout->render($displayData);
    }

    public static function pagination(JPagination $pagination = null)
    {
        if (null === $pagination || 1 >= $pagination->pagesTotal) {
            return;
        }

        $html = [];

        $html[] = '<div class="pagination">';
        $html[] = $pagination->getPagesLinks();
        $html[] = '</div>';

        return implode($html);
    }
}
