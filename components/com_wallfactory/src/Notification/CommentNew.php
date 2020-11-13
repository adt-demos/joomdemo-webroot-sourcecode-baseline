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

class CommentNew extends NotificationInterface implements NotificationSimpleInterface
{
    protected $tokens = array(
        'receiver_username',
        'comment_content',
        'post_link',
    );

    private $comment;

    public function setComment(\WallFactoryTableComment $comment)
    {
        $this->comment = $comment;
    }

    public function findReceivingUser()
    {
        if (!$this->comment instanceof \WallFactoryTableComment) {
            throw new \Exception('Comment not set!');
        }

        /** @var \WallFactoryTablePost $post */
        $post = \WallFactoryTable::getInstance('Post');
        $post->load($this->comment->post_id);

        if (!$post->id) {
            throw new \Exception(sprintf('Post not found "#%d"!', $this->comment->post_id));
        }

        if ((int)$this->comment->user_id === (int)$post->user_id) {
            throw new \Exception('Trying to send mail to same user that submitted the comment!');
        }

        $receiver = \JFactory::getUser($post->user_id);

        if (!$receiver->id) {
            throw new \Exception(sprintf('Receiver not found "#%d"!', $post->user_id));
        }

        return $receiver;
    }

    public function getParsedTokens()
    {
        return array(
            'receiver_username' => $this->getReceivingUser()->username,
            'comment_content'   => $this->comment->content,
            'post_link'         => \WallFactoryRoute::_('post&id=' . $this->comment->post_id, false, -1),
        );
    }
}
