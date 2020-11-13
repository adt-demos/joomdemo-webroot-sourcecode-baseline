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

use ThePhpFactory\Wall\Media\MediaFactory;

class MediaController extends BaseController
{
    public function preview()
    {
        // Check for CSRF token.
        if (!\JSession::checkToken('get')) {
            echo json_encode(array(
                'success' => false,
                'error'   => \JText::_('JINVALID_TOKEN'),
            ));

            return false;
        }

        $type = $this->input->getCmd('type');

        // Check if type is enabled.
        if (!$this->configuration->get('posting.' . $type . '.enabled', 1)) {
            echo json_encode(array(
                'success' => false,
                'error'   => sprintf('Media type "%s" not enabled!', $type),
            ));

            return false;
        }

        try {
            $mediaType = MediaFactory::build($type);
        } catch (\Exception $e) {
            echo json_encode(array(
                'success' => false,
                'error'   => sprintf('Media type "%s" not found!', $type),
            ));

            return false;
        }

        // Preview media.
        try {
            $data = $this->input->getRaw($type, $this->input->files->get($type));
            $preview = $mediaType->preview($data);

            $response = array(
                'success' => true,
                'output'  => $preview,
            );
        } catch (\Exception $e) {
            $response = array(
                'success' => false,
                'error'   => $e->getMessage(),
            );
        }

        // Return response.
        return json_encode($response);
    }
}
