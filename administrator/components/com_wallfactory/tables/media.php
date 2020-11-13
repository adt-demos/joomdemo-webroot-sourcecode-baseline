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

class WallFactoryTableMedia extends WallFactoryTable
{
    public $id;
    public $post_id;
    public $media_type;
    public $media_id;
    public $ordering;

    public function delete($pk = null)
    {
        if (!parent::delete($pk)) {
            return false;
        }

        $this->raise('onMediaRemoved', array(
            $this,
        ));

        return true;
    }
}
