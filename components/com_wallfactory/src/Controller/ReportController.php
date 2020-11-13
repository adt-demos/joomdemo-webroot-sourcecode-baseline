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

class ReportController extends BaseController
{
    public function form()
    {
        $id = $this->input->getInt('id');
        $type = $this->input->getString('type');

        $model = new \WallFactoryFrontendModelReport();

        $form = $model->getForm();

        $form->bind(array(
            'resource_id'   => $id,
            'resource_type' => $type,
        ));

        return $this->render('report.form', array(
            'form' => $form,
        ));
    }

    public function submit()
    {
        $report = $this->input->post->get('report', array(), 'array');
        $model = new \WallFactoryFrontendModelReport();
        $response = array();

        $report['user_id'] = \JFactory::getUser()->id;

        try {
            $model->submit($report);

            $response['success'] = true;
            $response['message'] = \WallFactoryText::_('report_task_submit_success');
        } catch (\Exception $e) {
            $e->getMessage();

            $response['success'] = false;
            $response['message'] = \WallFactoryText::_('report_task_submit_error');
            $response['error'] = $e->getMessage();
        }

        return json_encode($response);
    }
}
