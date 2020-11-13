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

class WallFactoryTableReport extends WallFactoryTable
{
    public $id;
    public $user_id;
    public $resource_id;
    public $resource_type;
    public $resource_user_id;
    public $resource_title;
    public $resource_excerpt;
    public $comment;
    public $resolved;
    public $actions;
    public $updated_at;
    public $created_at;

    public function setResource(WallFactoryReportResource $resource)
    {
        $this->resource_id = $resource->getId();
        $this->resource_type = $resource->getType();
        $this->resource_user_id = $resource->getUserId();
        $this->resource_title = JHtml::_('string.truncate', $resource->getTitle(), 30);
        $this->resource_excerpt = $resource->getExcerpt();
    }
}
