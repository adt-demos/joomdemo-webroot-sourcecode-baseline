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

class WallFactoryTableMediaVideo extends WallFactoryTable
{
    public $id;
    public $post_id;
    public $url;
    public $player;
    public $title;
    public $description;
    public $thumbnail;

    public function __construct(JDatabaseDriver $db, $name = null)
    {
        parent::__construct($db, '#__com_wallfactory_media_videos');
    }
}
