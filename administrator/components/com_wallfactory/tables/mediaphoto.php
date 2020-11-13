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

class WallFactoryTableMediaPhoto extends WallFactoryTable
{
    public $id;
    public $post_id;
    public $title;
    public $description;
    public $filename;
    public $path;
    public $params;

    public function __construct(JDatabaseDriver $db, $name = null)
    {
        parent::__construct($db, '#__com_wallfactory_media_photos');
    }

    public function getFolder()
    {
        $id = str_pad($this->id, 12, 0, STR_PAD_LEFT);

        return implode('/', array(
            substr($id, 0, 3),
            substr($id, 3, 3),
            substr($id, 6, 3),
            substr($id, 9, 3),
        ));
    }

    public function delete($pk = null)
    {
        if (!parent::delete($pk)) {
            return false;
        }

        $this->raise('onPhotoRemoved', array(
            $this,
        ));

        return true;
    }
}
