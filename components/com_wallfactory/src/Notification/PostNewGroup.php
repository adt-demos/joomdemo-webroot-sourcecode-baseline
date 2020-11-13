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

class PostNewGroup extends NotificationInterface implements NotificationGroupInterface
{
    protected $tokens = array(
        'administrator_username',
        'wall_title',
    );

    private $post;

    public function setPost(\WallFactoryTablePost $post)
    {
        $this->post = $post;
    }

    public function getParsedTokens()
    {
        return array(
            'administrator_username' => $this->getReceivingUser()->username,
            'wall_title'             => $this->getReceivingUser()->username,
        );
    }
}
