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

class SubscriberController extends BaseController
{
    public function index()
    {
        $user = \JFactory::getUser();
        $subscribers = new \WallFactoryFrontendModelSubscribers();

        $subscribers = $subscribers->findAll($user->id);

        return $this->render('subscriber.index', array(
            'subscribers' => $subscribers,
        ));
    }
}
