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

class WallFactoryFrontendModelLike extends JModelLegacy
{
    public function submit($resourceType, $resourceId, $userId)
    {
        // Check if user is logged in.
        if (!$userId) {
            throw new Exception(WallFactoryText::_('like_submit_error_guests_not_allowed'));
        }

        // Check if the user has already liked the resource.
        $like = WallFactoryTable::getInstance('Like');
        $data = array(
            'resource_type' => $resourceType,
            'resource_id'   => $resourceId,
            'user_id'       => $userId,
        );
        $like->load($data);

        if ($like->id) {
            throw new Exception(WallFactoryText::_('like_submit_error_already_liked'));
        }

        // Submit the like.
        $like->save($data);
    }

    public function remove($resourceType, $resourceId, $userId)
    {
        // Check if user is logged in.
        if (!$userId) {
            throw new Exception(WallFactoryText::_('like_remove_error_guests_not_allowed'));
        }

        // Check if the has liked the resource.
        $like = WallFactoryTable::getInstance('Like');
        $data = array(
            'resource_type' => $resourceType,
            'resource_id'   => $resourceId,
            'user_id'       => $userId,
        );
        $like->load($data);

        if (!$like->id) {
            throw new Exception(WallFactoryText::_('like_submit_error_not_liked'));
        }

        // Remove the like.
        $like->delete($like->id);
    }
}
