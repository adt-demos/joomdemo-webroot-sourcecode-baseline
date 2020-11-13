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

class WallFactoryReportComment implements WallFactoryReportResource
{
    /** @var WallFactoryTableComment */
    private $comment;

    public function __construct($resourceId)
    {
        $this->comment = WallFactoryTable::getInstance('Comment');
        $this->comment->load($resourceId);
    }

    public function getId()
    {
        return $this->comment->id;
    }

    public function getType()
    {
        return 'comment';
    }

    public function getUserId()
    {
        return $this->comment->user_id;
    }

    public function getTitle()
    {
        return $this->comment->content;
    }

    public function getExcerpt()
    {
        return $this->comment->content;
    }
}
