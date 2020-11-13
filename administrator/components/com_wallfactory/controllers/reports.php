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

class WallFactoryBackendControllerReports extends WallFactoryControllerAdmin
{
    public function resolve()
    {
        /** @var WallFactoryBackendModelReport $model */
        $cid = JFactory::getApplication()->input->get('cid', array(), 'array');
        $model = $this->getModel('Report');

        foreach ($cid as $id) {
            $model->resolve($id);
        }

        $this->setMessage('Reports resolved!');
        $this->setRedirect(WallFactoryRoute::view('reports'));
    }

    public function unresolve()
    {
        /** @var WallFactoryBackendModelReport $model */
        $cid = JFactory::getApplication()->input->get('cid', array(), 'array');
        $model = $this->getModel('Report');

        foreach ($cid as $id) {
            $model->unresolve($id);
        }

        $this->setMessage('Reports unresolved!');
        $this->setRedirect(WallFactoryRoute::view('reports'));
    }
}
