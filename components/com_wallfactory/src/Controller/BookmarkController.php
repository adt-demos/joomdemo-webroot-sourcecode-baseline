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

namespace ThePhpFactory\Wall\Controller;

defined('_JEXEC') or die;

class BookmarkController extends BaseController
{
    public function index()
    {
        $postId = $this->input->getInt('post_id');

        $bookmarksRepo = new \WallFactoryFrontendModelBookmarks();
        $postsRepo = new \WallFactoryFrontendModelPosts();

        $post = $postsRepo->findOne($postId);
        $bookmarks = $bookmarksRepo->findAll();

        $ssl = \JFactory::getApplication()->isSSLConnection() ? 1 : -1;

        $tokens = array(
            '{{ url }}'   => \WallFactoryRoute::task('post.show&id=' . $post->id, true, $ssl),
            '{{ title }}' => \JHtml::_('string.truncate', $post->content, 100),
        );

        foreach ($tokens as $i => $token) {
            $tokens[$i] = urlencode($token);
        }

        foreach ($bookmarks as $bookmark) {
            $bookmark->link = str_replace(
                array_keys($tokens),
                array_values($tokens),
                $bookmark->link
            );
        }

        return $this->render('bookmark.index', array(
            'bookmarks' => $bookmarks,
        ));
    }
}
