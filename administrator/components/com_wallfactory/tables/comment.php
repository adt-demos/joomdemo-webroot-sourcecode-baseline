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

class WallFactoryTableComment extends WallFactoryTable
{
    public $id;
    public $post_id;
    public $user_id;
    public $content;
    public $author_name;
    public $author_email;
    public $published = 1;
    public $updated_at;
    public $created_at;

    public function store($updateNulls = false)
    {
        $isNew = !(boolean)$this->id;

        if (!parent::store($updateNulls)) {
            return false;
        }

        $this->raise('onCommentStored', array($this, $isNew));

        return true;
    }
}
