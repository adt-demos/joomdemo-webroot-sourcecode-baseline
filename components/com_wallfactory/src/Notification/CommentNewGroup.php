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

namespace ThePhpFactory\Wall\Notification;

defined('_JEXEC') or die;

class CommentNewGroup extends NotificationInterface implements NotificationGroupInterface
{
    protected $tokens = array(
        'administrator_username',
        'comment_content',
        'post_link',
    );

    private $comment;

    public function setComment(\WallFactoryTableComment $comment)
    {
        $this->comment = $comment;
    }

    public function getParsedTokens()
    {
        return array(
            'administrator_username' => $this->getReceivingUser()->username,
            'comment_content'        => $this->comment->content,
            'post_link'              => \WallFactoryRoute::_('post&id=' . $this->comment->post_id, false, -1),
        );
    }
}
