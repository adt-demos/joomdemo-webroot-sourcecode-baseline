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

require_once __DIR__ . '/vendor/autoload.php';

class WallFactoryRouter extends JComponentRouterBase
{
    private $router;
    private $routes = array(
        'profile-show' => array(
            'task'   => 'profile.show',
            'params' => array(
                array('name' => 'id', 'filter' => 'integer'),
            ),
        ),

        'my-profile' => array(
            'task' => 'profile.show',
        ),

        'wall-show' => array(
            'task'   => 'wall.show',
            'params' => array(
                array('name' => 'user_id', 'filter' => 'integer'),
            ),
        ),

        'my-wall' => array(
            'task' => 'wall.show',
        ),

        'like-submit' => array(
            'task'   => 'like.submit',
            'params' => array(
                array('name' => 'type', 'filter' => 'string'),
                array('name' => 'id', 'filter' => 'integer'),
            ),
        ),

        'like-remove' => array(
            'task'   => 'like.remove',
            'params' => array(
                array('name' => 'type', 'filter' => 'string'),
                array('name' => 'id', 'filter' => 'integer'),
            ),
        ),

        'comment-form' => array(
            'task'   => 'comment.form',
            'params' => array(
                array('name' => 'post_id', 'filter' => 'integer'),
            ),
        ),

        'subscription-register' => array(
            'task'   => 'subscription.register',
            'params' => array(
                array('name' => 'user_id', 'filter' => 'integer'),
            ),
        ),

        'subscription-cancel' => array(
            'task'   => 'subscription.cancel',
            'params' => array(
                array('name' => 'user_id', 'filter' => 'integer'),
            ),
        ),

        'bookmarks-show' => array(
            'task'   => 'bookmark.index',
            'params' => array(
                array('name' => 'post_id', 'filter' => 'integer'),
            ),
        ),

        'load-more-comments' => array(
            'task'   => 'comment.load',
            'params' => array(
                array('name' => 'post_id', 'filter' => 'integer'),
            ),
        ),

        'subscriptions' => array(
            'task' => 'subscription.index',
        ),

        'post-search' => array(
            'task' => 'post.search',
        ),
    );

    public function __construct($app, $menu)
    {
        parent::__construct($app, $menu);

        $this->router = new \ThePhpFactory\Wall\Router($this->routes);
    }

    public function build(&$query)
    {
        return $this->router->build($query);
    }

    public function parse(&$segments)
    {
        return $this->router->parse($segments);
    }
}
