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

class WallFactoryReportPost implements WallFactoryReportResource
{
    /** @var WallFactoryTablePost */
    private $post;

    public function __construct($resourceId)
    {
        $this->post = WallFactoryTable::getInstance('Post');
        $this->post->load($resourceId);
    }

    public function getId()
    {
        return $this->post->id;
    }

    public function getType()
    {
        return 'post';
    }

    public function getUserId()
    {
        return $this->post->user_id;
    }

    public function getTitle()
    {
        return $this->post->content;
    }

    public function getExcerpt()
    {
        return $this->post->content;
    }
}
