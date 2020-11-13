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

class WallFactoryTableProfile extends WallFactoryTable
{
    public $user_id;
    public $name;
    public $description;
    public $avatar_source;
    public $thumbnail;
    public $notifications;
    public $created_at;

    protected $primaryKey = 'user_id';

    public function delete($pk = null)
    {
        if (!parent::delete($pk)) {
            return false;
        }

        $this->raise('onProfileRemoved', array(
            $this,
        ));

        return true;
    }
}
