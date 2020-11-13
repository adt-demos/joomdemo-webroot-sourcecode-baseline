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

class WallFactoryBackendControllerConfiguration extends JControllerLegacy
{
    private $redirect_view = 'dashboard';

    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->registerTask('apply', 'save');
    }

    public function save()
    {
        /** @var WallFactoryBackendModelConfiguration $model */
        $model = $this->getModel('Configuration');

        $data = $this->input->get('configuration', array(), 'array');
        $active = $this->input->get('active', 'general', 'cmd');
        $app = JFactory::getApplication();
        $route = WallFactoryRoute::view('configuration&active=' . $active);

        try {
            $model->save($data);

            $this->setMessage(WallFactoryText::_('configuration_task_save_success'));

            if ('save' == $this->getTask()) {
                $route = WallFactoryRoute::view($this->redirect_view);
            }
        } catch (Exception $e) {
            $app->enqueueMessage(WallFactoryText::_('configuration_task_save_error'), 'error');
            $app->enqueueMessage($e->getMessage(), 'error');
        }

        $this->setRedirect($route);

        return true;
    }

    public function cancel()
    {
        $this->setRedirect(WallFactoryRoute::view($this->redirect_view));
    }
}
