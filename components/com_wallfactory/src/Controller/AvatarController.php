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

class AvatarController extends BaseController
{
    public function upload()
    {
        $response = [];
        $user = \JFactory::getUser();
        $file = $this->input->files->get('file', [], 'array');

        $model = new \WallFactoryFrontendModelAvatar();

        try {
            $source = $model->upload($user->id, $file);

            $response['success'] = true;
            $response['message'] = \WallFactoryText::_('avatar_task_upload_success');
            $response['path'] = $source;
        }
        catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('avatar_task_upload_error');
            $response['error'] = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        jexit();
    }
}
